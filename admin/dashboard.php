<?php
    require_once 'includes/session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- latest jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- latest bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- font awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- bootstrap js -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script><script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    
    <!-- cdn of chartjs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
    require_once 'sidebar.php';
?>
<style>
    .content-body {
        margin-left: 25%;
        margin-right: 5%;
    }
</style>

    <!-- start of content body -->
    <div class="content-body">
        <h3>
            <?php
                $sql = "SELECT * FROM users WHERE user_id = $idSession;";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)){
                        $f_name = $row['f_name'];
                        echo 'Welcome ' .$f_name;
                    }
                }
            ?>
        </h3>
        
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="fa fa-money" aria-hidden="true" style="color: #00b09b;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text"><a href="#">Profit</a></div>
                                    <div class="stat-digit">
                                        <?php
                                            $sql1 = "SELECT SUM(total) AS total FROM order_details WHERE payment != 0;";
                                            $result1 = mysqli_query($conn, $sql1);
                                            if(mysqli_num_rows($result1) > 0){
                                                while($row1 = mysqli_fetch_assoc($result1)){
                                                    $total_profit = $row1['total'];
                                                    echo '<h6>&#8369;' .$total_profit. '</h6>';
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <!-- <i class="fa fa-male" aria-hidden="true"></i> -->
                                    <a href="users.php"><i class="fa fa-user" aria-hidden="true" style="color: #0082c8;"></i></a>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text"><a href="users.php">Customers</a></div>
                                    <div class="stat-digit">
                                        <?php 
                                            $sql2 = "SELECT * FROM users WHERE user_role_id = 1 AND is_deleted != 1;";
                                            $result2 = mysqli_query($conn, $sql2);
                                            $total_customer = mysqli_num_rows($result2);
                                            echo '<a href="users.php"><h3>' .$total_customer. '</h3></a>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <a href="orders.php"><i class="fa fa-shopping-cart" aria-hidden="true" style="color: #fc4a1a;"></i></a>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text"><a href="orders.php">Orders</a></div>
                                    <div class="stat-digit">
                                        <?php
                                            $sql3 = "SELECT * FROM order_details WHERE is_deleted != 1;";
                                            $result3 = mysqli_query($conn, $sql3);
                                            $total_order = mysqli_num_rows($result3);
                                            echo '<a href="orders.php"><h3>' .$total_order. '</h3></a>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <a href="product.php"><i class="fa fa-product-hunt" aria-hidden="true" style="color:#FFD200 ;"></i></a>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text"><a href="product.php">Products</a></div>
                                    <div class="stat-digit">
                                        <?php
                                            $sql4 = "SELECT * FROM product;";
                                            $result4 = mysqli_query($conn, $sql4);
                                            $total_product = mysqli_num_rows($result4);
                                            echo '<a href="product.php"><h3>' .$total_product. '</h3></a>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TOTAL ORDERS PER MONTH -->
                <?php
                    $query1 = "SELECT MONTHNAME(date_added) AS month, COUNT(*) AS orders FROM order_details GROUP BY MONTHNAME(date_added);";
                    $result1 = mysqli_query($conn, $query1);

                    foreach($result1 as $data1){
                        $month[] = $data1['month'];
                        $orders[] = $data1['orders'];
                    }
                ?>

                <div class="barchart1" style="height: 300px; width: 400px;">
                    <canvas id="myChart1"></canvas>
                </div>

                <!-- MOST SOLD CATEGORY -->
                <?php
                    $query2 = "SELECT product_category.name AS category, SUM(orders.quantity) AS sold FROM product INNER JOIN orders USING (product_id) INNER JOIN product_category USING (product_category_id) GROUP BY category ORDER BY sold DESC;";
                    $result2 = mysqli_query($conn, $query2);

                    foreach($result2 as $data2){
                        $category[] = $data2['category'];
                        $sold[] = $data2['sold'];
                    }1
                ?>
                
                <div class="barchart2" style="height: 36%; width: 44%;">
                    <canvas id="myChart2"></canvas>
                </div>




    </div>
    <!-- end of content body -->




    <script>
        // const labels = Utils.months({count: 7});
        const labels = <?php echo json_encode($month); ?>;
        const data = {
        labels: labels,
        datasets: [{
            label: 'TOTAL ORDERS PER MONTH',
            data: <?php echo json_encode($orders); ?>,
            backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
            ],
            borderWidth: 4
        }]
        };

        const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        },
        };

        const myChart = new Chart(
            document.getElementById('myChart1'),
            config
        );
    </script>












    <script>
    const labels2 = <?php echo json_encode($category); ?>;
    const data2 = {
    labels: labels2,
    datasets: [{
        label: 'Sold product',
        data: <?php echo json_encode($sold); ?>,
        backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)',
        'rgb(69, 18, 18)',
        'rgb(73, 76, 99)',
        'rgb(237, 12, 203)'

        ],
        hoverOffset: 4
    }]
    };

    const config2 = {
        type: 'pie',
        data: data2,
    };

    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
    );
    </script>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- limit records script -->
    <script>
        $(document).ready(function(){
            $('#form-select').change(function(){
                $('#form-record').submit();
            })
        })
    </script>

    <!-- modal -->
    <script>
        const modalAdd = document.querySelector('#add-category-modal');
        const openModalAdd = document.querySelector('.add-category-open-button');
        const closeModalAdd = document.querySelector('.add-category-close-button');

        openModalAdd.addEventListener('click', () => {
            modalAdd.showModal();
        })

        closeModalAdd.addEventListener('click', () => {
            modalAdd.close();
        })
    </script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<?php
    require_once 'footer.php';

?>