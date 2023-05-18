<?php

$action = isset($_GET['action']) ? $_GET['action'] : null;

if ($action == 'time') {
    // Setting up the Trigger signal for new Question Display
    $trigger_path = './trigger.json';
    $trigger_file = fopen($trigger_path, 'w');

    try {
        fwrite($trigger_file, json_encode(['value' => 'time'], JSON_PRETTY_PRINT));
        fclose($trigger_file);
    } catch (\Throwable $th) {
        echo 'Error';
    }
    exit();
} else if ($action == 'setLiveQuestion') {
    setUpTrigger(false);

    // Writing the new Question
    $data_path  = './data.json';
    $fp         = fopen($data_path, 'w');
    $to_write   = [
        'type'      => $_GET['type'],
        'question'  => $_GET['question'],
        'choices'   => json_decode($_GET['choices']),
        'timer'     => getTimer($_GET['mode']),
        'answer'    => $_GET['answer']
    ];

    try {
        fwrite($fp, json_encode($to_write, JSON_PRETTY_PRINT));
        fclose($fp);
    } catch (\Throwable $th) {
        echo 'Error!';
    }
    exit();
} else {
    exit();
}

function setUpTrigger()
{
    if (!isset($_GET['id'])) {
        return;
    }

    // Setting up the Trigger signal for new Question Display
    $trigger_path = './trigger.json';
    $trigger_file = fopen($trigger_path, 'w');

    try {
        fwrite($trigger_file, json_encode(['value' => "QID_{$_GET['id']}"], JSON_PRETTY_PRINT));
        fclose($trigger_file);
    } catch (\Throwable $th) {
        echo 'Error';
    }
}

function getTimer($mode)
{
    if ($mode == 1) return 30;
    else if ($mode == 2) return 60;
    else return 90;
}
