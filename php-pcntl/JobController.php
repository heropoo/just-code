<?php

class JobController extends Controller
{
    /**
     * 执行任务
     */
    public function actionRun()
    {
        declare(ticks=1);

        //安装信号处理器
        pcntl_signal(SIGTERM, [$this, 'sighandler']);
        pcntl_signal(SIGHUP, [$this, 'sighandler']);
        pcntl_signal(SIGUSR1, [$this, 'sighandler']);

        $pid = posix_getpid();

        file_put_contents(\Yii::getAlias('@console/runtime') . '/job.pid', $pid);

        echo 'Master pid: ' . $pid . PHP_EOL;

        $last_id = 0;

        $max_processes = 10;
        $children = []; //定义一个数组用来存储子进程的pid

        while (true) {
//            if (file_exists('/tmp/job-run.stop')) {    // todo 信号控制
//                $this->stdout('主动结束进程');
//                return ExitCode::OK;
//            }

            \Yii::$app->db->close();
            \Yii::$app->db->open();

            $job_ids = Job::find()->select('id')->where(['<=', '`last_exec_time` + `exec_interval`', time()])
                ->andWhere(['status' => Job::STATUS_NORMAL])
                ->andWhere(['>', 'id', $last_id])
                ->orderBy('last_exec_time ASC')->limit(100)
                //->createCommand()->getRawSql();
                ->column();

            if ($job_ids) {
                foreach ($job_ids as $job_id) {

//                    if (file_exists('/tmp/job-run.stop')) {
//                        $this->stdout('主动结束进程');
//                        return ExitCode::OK;
//                    }

                    if (count($children) < $max_processes) {
                        $pid = pcntl_fork();
                        if ($pid == -1) {
                            die('could not fork');
                        } else if ($pid) {  // 父进程执行的代码块
                            $children[] = $pid;
                            printf("Parent got child's pid: %d\n", $pid);
                        } else {    //子进程执行的代码块
                            $child_pid = posix_getpid();    //子进程获取自己的pid
                            echo "Child [$child_pid] start\n";

                            $this->runJob($job_id);

                            echo "Child [$child_pid] end\n";
                            exit(0);
                        }
                    } else {

                        echo '进程池满了。。。。。。。。。。。。';

                        $pid = pcntl_fork();
                        if ($pid == -1) {
                            die('could not fork');
                        } else if ($pid) {  // 父进程执行的代码块
                            //$children[] = $pid;
                            printf("Parent got child's pid: %d\n", $pid);
                            pcntl_wait($status); //等待子进程中断，防止子进程成为僵尸进程。
                            echo "Parent got child $pid 's status: $status\n";
                        } else {    //子进程执行的代码块
                            $child_pid = posix_getpid();    //子进程获取自己的pid
                            echo "Child [$child_pid] start\n";

                            $this->runJob($job_id);

                            echo "Child [$child_pid] end\n";
                            exit(0);
                        }
                    }
                }
//                sleep(1);
            } else {
                $last_id = 0;
                echo PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL . 'no jobs...' . PHP_EOL;
                sleep(10);
            }

            while (count($children) > 0) {
                foreach ($children as $key => $pid) {
                    $res = pcntl_waitpid($pid, $status, WNOHANG);    //获取返回指定pid的返回状态加了第二个参数非阻塞
                    if ($res == -1 || $res > 0) {
                        echo "Parent got child $pid 's status: $status\n";
                        unset($children[$key]);
                    }
                }
                echo "Current children count is " . count($children) . PHP_EOL;
                sleep(1);        //每一秒去轮询没有退出的子进程状态
            }


        }

        return 0;
    }

    protected function runJob($job_id)
    {
        \Yii::$app->db->close();
        \Yii::$app->db->open();

        /** @var Job $job */
        $job = Job::find()->where(['id' => $job_id])->one();

        $error_msg = '';

        try {
            $res = $this->run($job->call_action);
        } catch (\Exception $e) {
            $error_msg = $e->getMessage();
        }

        $job->last_exec_time = time();
        if (isset($res) && $res === 0) { //success
            $job->success += 1;
        } else {
            $job->failed += 1;
            $job->last_error_msg = $error_msg;
        }
        $job->save();
    }

    protected function sighandler($signo)
    {
        switch ($signo) {
            case SIGTERM:
                echo 'got SIGTERM ' . PHP_EOL;
                break;

            case SIGHUP:
                echo 'got SIGHUP ' . PHP_EOL;
                break;

            case SIGUSR1:
                echo 'got SIGUSR1 ' . PHP_EOL;
                break;
            default:        // 处理所有其他信号
                echo 'got other sig :' . $signo . PHP_EOL;
        }
    }
}
