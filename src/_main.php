<?php

$playerPod = new Pod('player');
$enemyPod = new Pod('enemy');

while (true) {
    // 0: x position of the pod
    // 1: y position of the pod
    // 2: x position of the next check point
    // 3: y position of the next check point
    // 4: distance to the next checkpoint
    // 5: angle between your pod orientation and the direction of the next checkpoint
    $playerInput = new PodInput(fscanf(STDIN, "%d %d %d %d %d %d"));
    $playerPod->update($playerInput);

    // 0: x position of the pod
    // 1: y position of the pod
    $enemyInput = new PodInput(fscanf(STDIN, "%d %d"));
    $enemyPod->update($enemyInput);

    $playerPod->logStatus();

    echo $playerPod;
}
