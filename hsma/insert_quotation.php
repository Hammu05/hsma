<?php
// Start the session to store success message
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the session
    $username = isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '';

    // Check if username is empty
    if (empty($username)) {
        echo "<script>alert('Error: Username not found in session.'); window.history.back();</script>";
        exit;
    }

    // Collect other form data
    $structural_options = isset($_POST['structural']) && is_array($_POST['structural']) ? implode(', ', $_POST['structural']) : '';
    $architectural_options = isset($_POST['architectural']) && is_array($_POST['architectural']) ? implode(', ', $_POST['architectural']) : '';
    $civil_options = isset($_POST['civil']) && is_array($_POST['civil']) ? implode(', ', $_POST['civil']) : '';
    $mechanical_options = isset($_POST['mechanical']) && is_array($_POST['mechanical']) ? implode(', ', $_POST['mechanical']) : '';
    $electrical_options = isset($_POST['electrical']) && is_array($_POST['electrical']) ? implode(', ', $_POST['electrical']) : '';
    $plumbing_options = isset($_POST['plumbing']) && is_array($_POST['plumbing']) ? implode(', ', $_POST['plumbing']) : '';

    $property_type = isset($_POST['propertyType']) ? htmlspecialchars($_POST['propertyType']) : '';
    $project_location = isset($_POST['projectLocation']) ? htmlspecialchars($_POST['projectLocation']) : '';
    $project_size = isset($_POST['projectSize']) ? htmlspecialchars($_POST['projectSize']) : '';
    $start_date = isset($_POST['startDate']) ? $_POST['startDate'] : '';
    $end_date = isset($_POST['endDate']) ? $_POST['endDate'] : '';
    $budget_range = isset($_POST['budgetRange']) ? $_POST['budgetRange'] : 0.00;
    $communication_mode = isset($_POST['communicationMode']) ? htmlspecialchars($_POST['communicationMode']) : '';
    $contact_time = isset($_POST['contactTime']) ? htmlspecialchars($_POST['contactTime']) : '';
    $materials_preference = isset($_POST['materialsPreference']) ? htmlspecialchars($_POST['materialsPreference']) : '';
    $design_requirements = isset($_POST['designRequirements']) ? htmlspecialchars($_POST['designRequirements']) : '';
    $services_needed = isset($_POST['servicesNeeded']) ? htmlspecialchars($_POST['servicesNeeded']) : '';
    $scope_of_work = isset($_POST['scopeOfWork']) ? htmlspecialchars($_POST['scopeOfWork']) : '';
    $special_requests = isset($_POST['specialRequests']) ? htmlspecialchars($_POST['specialRequests']) : '';
    $site_visit_date = isset($_POST['siteVisitDate']) ? $_POST['siteVisitDate'] : '';
    $site_visit_time = isset($_POST['siteVisitTime']) ? $_POST['siteVisitTime'] : '';

    $attachments = '';
    if (isset($_FILES['attachments']) && $_FILES['attachments']['error'] == 0) {
        $uploads_dir = 'uploads/';
        $attachments = $uploads_dir . basename($_FILES['attachments']['name']);
        if (!move_uploaded_file($_FILES['attachments']['tmp_name'], $attachments)) {
            echo "Error uploading file.";
        }
    }

    $sql = "INSERT INTO quotations (username, structural_options, architectural_options, civil_options, mechanical_options, electrical_options, plumbing_options, property_type, project_location, project_size, start_date, end_date, budget_range, communication_mode, contact_time, materials_preference, design_requirements, services_needed, scope_of_work, special_requests, site_visit_date, site_visit_time, attachments)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "sssssssssssssssssssssss",
            $username,
            $structural_options,
            $architectural_options,
            $civil_options,
            $mechanical_options,
            $electrical_options,
            $plumbing_options,
            $property_type,
            $project_location,
            $project_size,
            $start_date,
            $end_date,
            $budget_range,
            $communication_mode,
            $contact_time,
            $materials_preference,
            $design_requirements,
            $services_needed,
            $scope_of_work,
            $special_requests,
            $site_visit_date,
            $site_visit_time,
            $attachments
        );

        if ($stmt->execute()) {
            echo "<script>alert('Quotation submitted successfully!'); window.location.href='client_quotation.php';</script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    $conn->close();
}
