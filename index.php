<?php
declare(strict_types=1);

require 'WorkTimeCalculator.php';

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
$calculator = new WorkTimeCalculator($days);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $calculator->processRequest($_POST);
    $results = $calculator->getResults();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="" method="POST">
        <?php foreach ($days as $day): ?>
            <h2><?php echo $day; ?></h2>
            <label for="<?php echo $day; ?>_come">Come</label>
            <input type="datetime-local" name="<?php echo $day; ?>_come" id="<?php echo $day; ?>_come"><br><br>
            <label for="<?php echo $day; ?>_gone">Gone</label>
            <input type="datetime-local" name="<?php echo $day; ?>_gone" id="<?php echo $day; ?>_gone"><br><br>
        <?php endforeach; ?>
        <input type="submit" value="Submit">
    </form>

    <?php if (!empty($results)): ?>
        <div class="result">
            <?php foreach ($results as $day => $result): ?>
                <p><strong>Work duration on <?php echo $day; ?>:</strong> <?php echo $result['workTime']; ?></p>
                <p><strong>Debt on <?php echo $day; ?>:</strong> <?php echo $result['workOffTime']; ?> minutes</p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>
