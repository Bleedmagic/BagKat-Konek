<?php
include 'config.php';

$sql_pending_requests_count = "SELECT COUNT(*) AS pending_count FROM sign_up_requests_temp WHERE status = 'PENDING'";
$result_pending_requests_count = $conn->query($sql_pending_requests_count);
$pending_count = $result_pending_requests_count->fetch_assoc()['pending_count'];

$sql_total = "SELECT COUNT(res_id) as total_residents FROM residents";
$result_total = mysqli_query($conn, $sql_total);

$total_residents = 0;
if ($result_total) {
    $row_total = mysqli_fetch_assoc($result_total);
    $total_residents = $row_total['total_residents'];
}

$sql_male = "SELECT COUNT(res_id) as male_count FROM residents WHERE res_gender = 'Male'";
$result_male = mysqli_query($conn, $sql_male);
$row_male = mysqli_fetch_assoc($result_male);
$male_count = $row_male['male_count'];

$sql_female = "SELECT COUNT(res_id) as female_count FROM residents WHERE res_gender = 'Female'";
$result_female = mysqli_query($conn, $sql_female);
$row_female = mysqli_fetch_assoc($result_female);
$female_count = $row_female['female_count'];

$sql_yearly_reg = "
    SELECT YEAR(res_date_registered) AS registration_year, COUNT(*) AS total_registered
    FROM residents
    GROUP BY YEAR(res_date_registered)
    ORDER BY YEAR(res_date_registered)";

$stmt = $conn->prepare($sql_yearly_reg);
$stmt->execute();

$result_yearly_reg = mysqli_stmt_get_result($stmt);

$years_reg = [];
$total_reg = [];

while ($row_yearly_reg = mysqli_fetch_assoc($result_yearly_reg)) {
    $years_reg[] = $row_yearly_reg['registration_year'];
    $total_reg[] = $row_yearly_reg['total_registered'];
};

$sql_ages = "
    SELECT
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, res_dob, CURDATE()) BETWEEN 0 AND 14 THEN 1 ELSE 0 END) AS age_0_14,
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, res_dob, CURDATE()) BETWEEN 15 AND 24 THEN 1 ELSE 0 END) AS age_15_24,
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, res_dob, CURDATE()) BETWEEN 25 AND 54 THEN 1 ELSE 0 END) AS age_25_54,
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, res_dob, CURDATE()) >= 55 THEN 1 ELSE 0 END) AS age_55_plus
    FROM
        residents";

$stmt = $conn->prepare($sql_ages);
$stmt->execute();

$result_ages = mysqli_stmt_get_result($stmt);

$ages_0_14;
$ages_15_24;
$ages_25_54;
$ages_55_p;

if ($row_ages = mysqli_fetch_assoc($result_ages)) {
    $ages_0_14   = $row_ages['age_0_14'];
    $ages_15_24  = $row_ages['age_15_24'];
    $ages_25_54  = $row_ages['age_25_54'];
    $ages_55_p   = $row_ages['age_55_plus'];
};

$eduv_lvl = "SELECT res_education_level, COUNT(*) AS total_count FROM residents GROUP BY res_education_level";

$stmt = $conn->prepare($eduv_lvl);
$stmt->execute();

$result_educ_lvl = mysqli_stmt_get_result($stmt);

$elem;
$high;
$coll;

while ($row_educ_lvl = mysqli_fetch_assoc($result_educ_lvl)) {
    if ($row_educ_lvl['res_education_level'] == 'ELEMENTARY') {
        $elem = $row_educ_lvl['total_count'];
    } else if ($row_educ_lvl['res_education_level'] == 'HIGH SCHOOL') {
        $high = $row_educ_lvl['total_count'];
    } else if ($row_educ_lvl['res_education_level'] == 'COLLEGE') {
        $coll = $row_educ_lvl['total_count'];
    }
};

mysqli_free_result($result_yearly_reg);
mysqli_close($conn);
