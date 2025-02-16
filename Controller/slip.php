<?php
$id = $_GET['id'] ?? 1;
$type = $_GET['type'] ?? 'worker';
$page = "Voucher Print";
$com_un = 1;
$mode = 1;

include "../Model/connection.php";

$query = "SELECT * from company order by id desc limit 1";
$res = mysqli_query($con, $query);
if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $propertyName = $row['name'];
    // $com_un = $row['com_un'] ?? 1;
    $companyName = $row['company_name'];

} else {
    $companyName = '';
    $propertyName = '';
}

if ($type == 'party') {
    $table_name = 'p_khata';
    $table_detail = 'party';
} else {
    $table_detail = 'workers';
    $table_name = 'khata';
}

$wQ = "SELECT * from $table_detail where deleted_at is  null";
$res = $con->query($wQ);
$detail = [];
if ($res->num_rows > 0) {
    while ($rowQ = $res->fetch_assoc()) {
        $detail[$rowQ['id']] = $rowQ;
    }
}

?>
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;

    }

    .voucher {
        width: 100%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #000;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-size: 12px;
    }

    header {
        margin-bottom: 20px;
        text-align: center;
    }

    .title-box {
        /* border: 1px solid #000; */
        display: inline-block;
        padding: 5px;
    }

    .voucher-info {
        display: flex;
        /* justify-content: space-between; */
        justify-content: space-evenly;
        margin-bottom: 20px;
    }

    .voucher-info .left,
    .voucher-info .right {
        width: 45%;
        text-align: right;
    }

    .voucher-info p {
        margin: 2px 0;
    }

    .payment-details {
        margin-bottom: 20px;
    }

    .payment-details .row {
        display: flex;
        justify-content: space-between;
    }

    .column {
        width: 45%;
    }

    .financial-details {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .financial-details th,
    .financial-details td {
        border: 1px solid #000;
        padding: 10px;
        text-align: left;
    }

    .financial-details th {
        background-color: #f2f2f2;
    }

    .financial-details .main-head {
        font-weight: bold;
    }

    .financial-details .sub-head {
        padding-left: 20px;
    }

    .remarks {
        margin-bottom: 20px;
    }

    .remarks p {
        margin: 0 0 10px 0;
    }

    .signatures .row {
        display: flex;
        justify-content: space-between;
    }

    .signatures .column {
        width: 45%;
    }

    .signatures p {
        margin: 0 0 10px 0;
    }

    h1 {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .bordered {
        border: 1px solid black;
        padding: 3px;
        font-weight: bold;
        font-size: 15px;
    }

    .bordered1 {
        border: 1px solid black;
        padding: 3px;
        font-weight: normal;
        font-size: 15px;
    }

    @media print {
        .card {
            page-break-inside: avoid !important;
        }
    }

    @page {
        size: A4 Portrait !important;
        /* margin: 0; */
    }
</style>
<div>

    <div class="row" with="max-width:90%">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php

                    function numberToWords($number)
                    {
                        $words = [
                            'zero',
                            'one',
                            'two',
                            'three',
                            'four',
                            'five',
                            'six',
                            'seven',
                            'eight',
                            'nine',
                            'ten',
                            'eleven',
                            'twelve',
                            'thirteen',
                            'fourteen',
                            'fifteen',
                            'sixteen',
                            'seventeen',
                            'eighteen',
                            'nineteen'
                        ];

                        $tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

                        if ($number < 20) {
                            return $words[$number];
                        } elseif ($number < 100) {
                            return $tens[(int) ($number / 10)] . ($number % 10 ? ' ' . $words[$number % 10] : '');
                        } elseif ($number < 1000) {
                            return $words[(int) ($number / 100)] . ' hundred' . ($number % 100 ? ' and ' . numberToWords($number % 100) : '');
                        } elseif ($number < 1000000) {
                            return numberToWords((int) ($number / 1000)) . ' thousand' . ($number % 1000 ? ' ' . numberToWords($number % 1000) : '');
                        } elseif ($number < 1000000000) {
                            return numberToWords((int) ($number / 1000000)) . ' million' . ($number % 1000000 ? ' ' . numberToWords($number % 1000000) : '');
                        }

                        return 'Number is too large to convert to words';
                    }


                    $query = "SELECT * from $table_name where id = '$id' and deleted_at is null order by id ";
                    $res = mysqli_query($con, $query);
                    if (mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_assoc($res);
                        ?>
                        <div class="voucher" style="max-width:90%">
                            <header>
                                <div class="row" style="display: flex;justify-content:space-between">
                                    <div class="title-box col-sm-3">
                                        <?php
                                        if ($mode == '1') {
                                            // $companyName = '<h1>S.P.G ENTERPRISES</h1>';
                                            $companyName = $companyName;
                                            $staric = '';
                                            ?>
                                            <img src="../Assets/Images/AlShaikh.jpg" width="100%" height="100px"></img>
                                            <?php
                                        } else {
                                            if ($com_un == 1) {
                                                $companyName = $companyName;
                                            } else {
                                                $companyName = '';
                                            }
                                            $staric = '*';
                                            ?>
                                            <div style="width:100%;height:100px"></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="title-box col-sm-4">
                                        <h1 style="font-size:20px;"><?php echo $propertyName; ?></h1>
                                        <?php
                                        echo $companyName;
                                        ?>
                                    </div>
                                    <div class="title-box col-sm-3 text-break">
                                        <h1 style="width: 80%; height:fit-content;padding:10px;font-size:50px;border:1px solid black;">
                                            <?php echo $dr = $row['debit'] > 0 ? 'DR' : '';
                                          echo  $cr = $row['credit'] > 0 ? 'CR' : ''; ?>
                                        </h1>
                                        <p style="width: 80%;font-weight: bolder;">
                                            <?php
                                            if (isset($row['POSTED']) && $row['POSTED'] == 'Y') {
                                                echo $staric;
                                            } else {
                                                echo $staric;
                                            }
                                            ;
                                            ?>
                                        </p>
                                    </div>

                                </div>
                                <div class="voucher-info">
                                    <div class="left">

                                    </div>
                                    <div class="right" style="font-size:medium;font-weight:bolder">
                                        <!-- <p><strong>Paid:</strong> 0.00</p>
                                    <p><strong>Payable Balance:</strong> 0.00</p> -->
                                        <p><strong>Voucher No: </strong><?php echo $row['id']; ?></p>
                                        <p><strong>Date: </strong>
                                            <?php echo date("d-M-Y", strtotime($row['receipt_date'])); ?></p>
                                    </div>
                                </div>
                            </header>

                            <section class="remarks">
                                <p class="row"><strong class="col-sm-2">RECEIVED BY: </strong> <span class="col-sm-10"
                                        style="border-bottom: 1px solid black;text-transform:capitalize;font-size:13px"> <?php
                                        $array = $detail[$row['worker_id']];

                                        echo !empty($row['debit'])
                                            ? 'Paid To Mrs/Mr/SNo/Dr ' . $array['name']
                                            : 'Receiving with thanks to Mrs/Mr/SNo/Dr ' . $array['name'];
                                        ?> </span></p>

                                <p class="row"><strong class="col-sm-2">SUM OF RUPEES:</strong> <span class="col-sm-10"
                                        style="border-bottom: 1px solid black;text-transform:capitalize;font-size:13px"
                                        id="numInRs"> </span> </p>

                                <br>
                                <br>
                                <br>
                                <br>

                            </section>
                            <section class="row">
                                <div class="col-sm-6">
                                    <table style="width: 100%;border:1px solid black; text-align:center">
                                        <thead>
                                            <tr>
                                                <th class="bordered" style="width:80%;">Reason</th>
                                                <th class="bordered">Transection Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="bordered" style="font-weight:normal">
                                                    <?php echo $row['reason']; ?>
                                                </td>
                                                <td class="bordered" id="totalPaymentAmount">
                                                    0
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-5">

                                </div>
                            </section>

                            <br>
                            <br>
                            <br>

                            <section class="row mt-3"
                                style="text-align: center; display:flex; justify-content:space-around;">
                                <!-- <div class="col-sm-12"> -->
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">___________________</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">___________________</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">___________________</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">___________________</p>
                                <!-- </div> -->
                            </section>
                            <section class="row " style="text-align: center; display:flex; justify-content:space-around;">
                                <!-- <div class="col-sm-12"> -->
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">Prepared By</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">Checked By</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">Approved By</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">Sanctioned By</p>
                                <!-- </div> -->
                            </section>

                        </div>
                        <?php
                        $totalAmount = !empty($row['debit']) ? $row['debit'] : $row['credit'];
                        $dr = $row['debit'] > 0 ? '(DR)' : '';
                        $cr = $row['credit'] > 0 ? '(CR)' : '';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var a = document.getElementById("totalPaymentAmount")
    a.innerText = `<?php echo number_format($totalAmount) . ' ' . $dr . $cr ?>`;
    var b = document.getElementById('numInRs')
    b.innerText = `<?php echo numberToWords($totalAmount); ?> Only`;
</script>