<?php

namespace App\Outputs;

use App\Outputs\ProfileFormatter;

class HTMLFormat implements ProfileFormatter
{
    private $response;

    public function setData($profile)
    {
        
        $output = <<<HTML
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile of {$profile->getFullName()}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Profile.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #f4f7fa;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
            color: #6f42c1;
        }
        .section-title {
            border-bottom: 2px solid #6f42c1;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #6f42c1;
        }
        .card {
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Profile of {$profile->getFullName()}</h1>
        <div class="text-center">
        </div>

        <h2 class="section-title">Personal Information</h2>
        <p><strong>Date of Birth:</strong> {$profile->getBirthInformation()['date_of_birth']}</p>
        <p><strong>Birth Event:</strong> {$profile->getBirthInformation()['birth_event']}</p>
        <p><strong>Address:</strong> 
            <span class="text-capitalize">
                {$profile->getContactDetails()['address']['street']}, 
                {$profile->getContactDetails()['address']['city']}, 
                {$profile->getContactDetails()['address']['state']}, 
                {$profile->getContactDetails()['address']['zip_code']}, 
                {$profile->getContactDetails()['address']['country']}
            </span>
        </p>

        <h2 class="section-title">Education</h2>
        <p>
            <strong>Degree:</strong> {$profile->getEducation()['degree']} 
            at {$profile->getEducation()['university']} 
            (Graduated: {$profile->getEducation()['graduation_date']})
        </p>
        <h3>Achievements:</h3>
        <ul>
HTML;

        //education
        foreach ($profile->getEducation()['achievements'] as $achievement) {
            $output .= "<li>{$achievement}</li>";
        }
        $output .= "</ul>";

        //experience
        $output .= "<h2 class='section-title'>Experience</h2><ul>";
        foreach ($profile->getExperience() as $job) {
            $output .= "<li><strong>{$job['job_title']}</strong> at {$job['organization']} ({$job['start_date']} - " . ($job['end_date'] ?? 'Present') . ")<br>Description: {$job['description']}</li>";
        }
        $output .= "</ul>";

        //philanthrophic gesture
        $output .= "<h2 class='section-title'>Philanthropy</h2><ul>";
        foreach ($profile->getPhilanthropy() as $philanthropy) {
            $output .= "<li>{$philanthropy['role']} (Since: {$philanthropy['start_date']})<br>Description: {$philanthropy['description']}</li>";
        }
        $output .= "</ul>";

        //values
        $output .= "<h2 class='section-title'>Values</h2><p>" . implode(", ", $profile->getValues()) . "</p>";

        //languages
        $output .= "<h2 class='section-title'>Languages</h2><ul>";
        foreach ($profile->getLanguages() as $language) {
            $output .= "<li>{$language['language']} - {$language['proficiency']}</li>";
        }
        $output .= "</ul>";

        $output .= "</div>";

        //script source
        $output .= <<<HTML
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
HTML;

        $this->response = $output;
    }

    public function render()
    {
        header('Content-Type: text/html');
        return $this->response;
    }
}
