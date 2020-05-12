<?php

function gen1() {
  for( $i = 1; $i <= 10; $i++ ) {
    echo "GEN1 : {$i}".PHP_EOL;
    // sleep没啥意思，主要就是运行时候给你一种切实的调度感，你懂么
    // 就是那种“你看！你看！尼玛,我调度了！卧槽”
    sleep( 1 );
    // 这句很关键，表示自己主动让出CPU，我不下地狱谁下地狱
    yield;
  }
}
function gen2() {
  for( $i = 1; $i <= 10; $i++ ) {
    echo "GEN2 : {$i}".PHP_EOL;
    // sleep没啥意思，主要就是运行时候给你一种切实的调度感，你懂么
    // 就是那种“你看！你看！尼玛,我调度了！卧槽”
    sleep( 1 );
    // 这句很关键，表示自己主动让出CPU，我不下地狱谁下地狱
    yield;
  }
}
$task1 = gen1();
$task2 = gen2();
while( true ) {
  // 首先我运行task1，然后task1主动下了地狱
  echo $task1->current();
  // 这会儿我可以让task2介入进来了
  echo $task2->current();
  // task1恢复中断
  $task1->next();
  // task2恢复中断
  $task2->next();
}
