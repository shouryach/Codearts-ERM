<!doctype html>
<html lang="en">

    <head>
        <!-- Header CSS files -->
        <?php include 'header_css.php'; ?>
        <style type="text/css">
            .lunch-break-btn-disabled {
                color: red;
            }
            .evening-break-btn-disabled {
                color: red;
            }
        </style>
        <?php
            if($_SESSION['emp_id'] == '')
            {
              echo "<script>location.href='http://localhost/codearts/login.php';</script>";
            }
        ?>
        <title>Access Logs - CERM :: Codearts Employee Relationship Management</title>
    </head>

    <body>
        <header class="custom-header">
            <!-- Dashboard Top Info Panel -->
            <?php include 'info_panel.php'; ?>
        </header>
        <main class="custom-dahboard-main">
            <div class="custom-page-wrap-dp">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- Dashboard Left Sidebar -->
                            <?php include 'dashboard.php'; ?>
                        </div>
                        <div class="col-lg-9">
                            <section class="inner-head-brd">
                                <h2>Access Log</h2>
                                <ul>
                                    <li><a href="<?php echo $baseURL; ?>">Home</a></li>
                                    <li>Access Log</li>
                                </ul>
                            </section>
                            <?php if($_SESSION['emp_type'] == 'hr' || $_SESSION['emp_type'] == 'admin') { ?>
                                <section class="employee-profiles">
                                    <div class="row">
                                        <?php 
                                            $sql1 = "SELECT * FROM capms_admin_users";
                                            $result1 = mysqli_query($con, $sql1);
                                            if($result1->num_rows > 0)
                                            {
                                                while($row1 = mysqli_fetch_assoc($result1))
                                                {
                                                    ?>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="employee-profiles-thubmnail">
                                                                <div class="dropdown employee-thumb-toggle">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item"
                                                                            href="javascript:void(0)"><?php echo ucwords($row1['user_type']); ?></a>
                                                                        <a class="dropdown-item" href="employee_access_log.php?user_id=<?php echo $row1['id']; ?>">Access Log</a>
                                                                    </div>
                                                                </div>
                                                                <div class="employee-image">
                                                                    <a href="employee_access_log.php?user_id=<?php echo $row1['id']; ?>"><img src="assets/uploads/user_featured_images/<?php echo $row1['user_featured_image']; ?>" alt=""></a>
                                                                </div>
                                                                <div class="employee-content">
                                                                    <a href="employee_access_log.php?user_id=<?php echo $row1['id']; ?>"><?php echo $row1['user_fullname']; ?></a>
                                                                    <h6><?php echo $row1['user_designation']; ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                </section>
                            <?php } else if($_SESSION['emp_type'] == 'employee' || $_SESSION['emp_type'] == '') { ?>
                                <section>
                                    <a href="Javascript:void(0)" id="lunch-break-btn" class="lunch-break-btn">Lunch Break</a>
                                    <br>
                                    <a href="Javascript:void(0)" id="evening-break-btn" class="evening-break-btn">Evening Break</a>
                                </section>
                                <section class="access-logs">
                                    <table class="table weekly-time-table-dp">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Login Time</th>
                                                <th scope="col">Lunch Break</th>
                                                <th scope="col">Evening Breaks</th>
                                                <th scope="col">Logout Time</th>
                                                <th scope="col">Total Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql2 = "SELECT * FROM capms_login_information WHERE user_id = '".$_SESSION['emp_id']."' ";
                                                $result2 = mysqli_query($con, $sql2);
                                                if($result2->num_rows > 0)
                                                {
                                                    while($row2 = mysqli_fetch_assoc($result2))
                                                    {
                                                        ?>
                                                        <tr>
                                                            <!-- login date -->
                                                            <th scope="row">
                                                                <?php echo date('d-m-Y', strtotime($row2['login_date'])); ?>
                                                            </th>
                                                            <!-- login time -->
                                                            <td class="bg-dp-drk">
                                                                <?php
                                                                    $login_time = str_replace('-', ':', $row2['login_time']);
                                                                    $login_time = date('G:i A' ,strtotime($login_time));
                                                                    echo $login_time;
                                                                ?>
                                                            </td>
                                                            <!-- lunch break duration -->
                                                            <td>
                                                                <?php
                                                                    if($row2['lunch_break_start'] != '')
                                                                    {
                                                                        echo date('h:i', strtotime($row2['lunch_break_start']));
                                                                    }
                                                                    if($row2['lunch_break_end'] != '')
                                                                    {
                                                                        echo " - ".date('G:i', strtotime($row2['lunch_break_end']));
                                                                    }
                                                                ?>
                                                            </td>
                                                            <!-- evening break duration -->
                                                            <td>
                                                                <?php
                                                                    if($row2['evening_break_start'] != '')
                                                                    {
                                                                        echo date('h:i', strtotime($row2['evening_break_start']));
                                                                    }
                                                                    if($row2['evening_break_end'] != '')
                                                                    {
                                                                        echo " - ".date('G:i', strtotime($row2['evening_break_end']));
                                                                    }
                                                                ?>
                                                            </td>
                                                            <!-- logout time -->
                                                            <td class="bg-dp-drk">
                                                                <?php
                                                                    $logout_time = str_replace('-', ':', $row2['logout_time']);
                                                                    $logout_time = date('G:i A' ,strtotime($logout_time));
                                                                    echo $logout_time;
                                                                ?>
                                                            </td>
                                                            <!-- total hours -->
                                                            <td>7.45</td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </section>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="custom-footer">
            <!-- Copyright Content file -->
            <?php include 'copyright_content.php'; ?>
        </footer>
        <!-- Footer JS files -->
        <?php include 'footer_js.php' ?>
        <script src="assets/js/jquery-min.js"></script>
        <script>
            jQuery( document ).ready(function() {
                lunch_break_time_duration('blank');
                jQuery('#lunch-break-btn').click(function () {
                    if(jQuery(this).hasClass('lunch-break-btn-disabled'))
                    {
                        lunch_break_time_duration('stop_now');
                    }
                    else
                    {
                        lunch_break_time_duration('start_now');
                    }
                });
                function lunch_break_time_duration(status)
                {
                    var status = status;
                    var emp_id = <?php echo $_SESSION['emp_id']; ?>;
                    jQuery.ajax({
                        type: "GET",
                        url: "<?php echo $baseURL; ?>ajax_lunch_break_duration.php",
                        data: {
                            status: status,
                            emp_id: emp_id
                        },
                        dataType: "json",
                        success: function(response){
                            console.log(response);
                            if(response.status == 'lunch_break_started')
                            {
                                jQuery('#lunch-break-btn').addClass('lunch-break-btn-disabled');
                            }
                            else if(response.status == 'lunch_break_stopped')
                            {
                                jQuery('#lunch-break-btn').removeClass('lunch-break-btn-disabled');
                            }
                        }
                    });
                }
                /* evening break time duration */
                evening_break_time_duration('blank');
                jQuery('#evening-break-btn').click(function () {
                    if(jQuery(this).hasClass('evening-break-btn-disabled'))
                    {
                        evening_break_time_duration('stop_now');
                    }
                    else
                    {
                        evening_break_time_duration('start_now');
                    }
                });
                function evening_break_time_duration(status)
                {
                    var status = status;
                    var emp_id = <?php echo $_SESSION['emp_id']; ?>;
                    jQuery.ajax({
                        type: "GET",
                        url: "<?php echo $baseURL; ?>ajax_evening_break_duration.php",
                        data: {
                            status: status,
                            emp_id: emp_id
                        },
                        dataType: "json",
                        success: function(response){
                            console.log(response);
                            if(response.status == 'evening_break_started')
                            {
                                jQuery('#evening-break-btn').addClass('evening-break-btn-disabled');
                            }
                            else if(response.status == 'lunch_break_stopped')
                            {
                                jQuery('#evening-break-btn').removeClass('evening-break-btn-disabled');
                            }
                        }
                    });
                }
            });
        </script>
    </body>
</html>