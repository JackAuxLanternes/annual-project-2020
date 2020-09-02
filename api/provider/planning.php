<?php
include('../includes/config.php');
if(!$connected) header('Location:../index.php');
$userData = $database->find('SELECT * FROM user WHERE email = ?', [$_SESSION['user']]);

if($userData['statut'] === 'customer') header('Location:../index.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Perfect Concierge - Liste des réservations</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/checkout/">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">
    <style>
        table,
        td {
            border: 1px solid #333;
        }
    </style>
</head>
<body class="bg-light">

<?php
include("../includes/header.php");
$today = date('y-m-d');
$todayPlusSevenDays = date('y-m-d',strtotime('+7 day',strtotime('today')));
$query = "SELECT *, cast(datetime as date), cast(datetime as time) FROM booking WHERE provider_id='".$_GET['id']."' AND (datetime BETWEEN '".$today."' AND '".$todayPlusSevenDays."')";

$weekmultiplier = 0;
if(isset($_GET['week'])) $weekmultiplier = $_GET['week'];

$bookdata = $database->getPdo()->query($query);
?>

<div class="container text-center">

    <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">
            <?php
            $weekless = $weekmultiplier - 1;
            $weekmore = $weekmultiplier + 1;
            if ($weekmultiplier != 0){
                echo '<a href="planning.php?id='.$_GET['id'].'&week='.$weekless.'" class="btn btn-warning">Semaine précédente</a>';
            }
            ?>
        </span>
        <a href="planning.php?id=<?php echo $_GET['id']?>&week=<?php echo $weekmore?>" class="btn btn-warning">Semaine suivante</a>
    </h4>

    <table>
        <thead>
        <tr>
            <th colspan="7">Planning</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            for($i = 0; $i < 7; $i += 1){
                $day = 7*$weekmultiplier + $i;
                $thisday = strtotime('+'.$day.' day',strtotime('today'));
                echo "<td>".date('d/m',$thisday)."</td>";
            }
            ?>
        </tr>
        <tr>

            <?php
            foreach ($bookdata as $booking){

                $service = $database->find('SELECT name FROM service WHERE id=?',[$booking['service_id']]);

                for($i = 0; $i < 7; $i += 1){
                    $day = 7*$weekmultiplier + $i;
                    $thisday = strtotime('+'.$day.' day',strtotime('today'));
                    if(date('Y-m-d', $thisday) == $booking['cast(datetime as date)']){?>
                        <td>
                            <h6 class="my-0"><?php echo $service['name']. " par " . $userData['first_name'] . " " . $userData['last_name'];?></h6>
                            <small class="text-muted">
                                <?php echo $booking['cast(datetime as time)'] . " à " . $booking['address'];?>
                            </small>
                            </td>
            <?php
                    }
                }
            }
            ?>
        </tr>
        </tbody>
    </table>


</div>
<?php include('../includes/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>