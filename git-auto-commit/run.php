<?php

require_once __DIR__ . '/GitCommand.php';

$base_path = '/var/www/cgi-bin';
$private_key = '/root/.ssh/id_rsa';

$all_projects = [
    'project0',
    'project1',
    'project2',
    'project3',
];

$options = getopt("p:AL");

if (!empty($options['p'])) {
    $projects = [$options['p']];
} else if (isset($options['A'])) {
    $projects = $all_projects;
} else if (isset($options['L'])) {
    var_dump($all_projects);
    exit(0);
} else {
    echo "Usage:\n\tphp run.php [-p <project>] [-A] [-L]\n\n";
    exit(0);
}

var_dump($projects);
//exit;

foreach ($projects as $project) {
    $git = new GitCommand($base_path . '/' . $project);

    $res = $git->run('git checkout master');
    echo $git->output_result($res);

    $res = $git->run('git reset --hard FETCH_HEAD');
    echo $git->output_result($res);

    $res = $git->run('git pull origin master');
    echo $git->output_result($res);

    $res = $git->run('git submodule update --remote');
    echo $git->output_result($res);

    $res = $git->run('git status');
    echo $git->output_result($res);

    if (strpos($res['success_msg'], 'example') > 0) {
        $res = $git->run('git add example');
        echo $git->output_result($res);

        $res = $git->run('git commit -m"auto update example"');
        echo $git->output_result($res);

        $res = $git->run("gitsh-unix.sh -i $private_key push");
        echo $git->output_result($res);
    }

    echo '----------------------------------------------------------------------' . PHP_EOL;
}


