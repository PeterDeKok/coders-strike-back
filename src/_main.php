<?php

$checkpoints = new CheckpointCollection();
$playerPod = new Pod('player');
$enemyPod = new Pod('enemy');

while (true) {
    // 0: x position of the pod
    // 1: y position of the pod
    // 2: x position of the next check point
    // 3: y position of the next check point
    // 4: distance to the next checkpoint
    // 5: angle between your pod orientation and the direction of the next checkpoint
    $playerInput = fscanf(STDIN, "%d %d %d %d %d %d");
    $targetShouldChange = $playerPod->update($playerInput);

    // 0: x position of the pod
    // 1: y position of the pod
    $enemyInput = fscanf(STDIN, "%d %d");
    $enemyPod->update($enemyInput);

    try {
        if ($targetShouldChange) {
            $lastCheckpoint = $checkpoints->findCheckpoint($playerPod->getTarget());

            if ($lastCheckpoint >= 0)
                $checkpoints->getCheckpoint($lastCheckpoint)->hit();

            $playerPod->setTarget($playerInput[2], $playerInput[3]);

            $checkpoints->seeCheckpoint($playerInput[2], $playerInput[3]);
        }
    } catch(Exception $e) {

    }

    $checkpoints->logCheckpoints();

    echo $playerPod;
}
