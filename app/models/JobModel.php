<?php

namespace App\Models;

use App\Core\Classes\Job_Internship;
use core\Model;

class JobModel extends Model
{
    public function getJobInternships(){
        return $this->selectAll('job_internship');
    }

    public function postJobInternship(Job_Internship $job_internship){
        return $this->insertObject('job_internship',$job_internship);
    }

    public function getMyJobInternship($id){
        return $this->selectFromMultipleTables(
            ['job_internship', 'job_internship_request'],
            ['job_internship.id = job_internship_request.jobId'],
            ['JOIN'],
            'job_internship.*,job_internship_request.action',
            'job_internship_request.studentId = "'.$id.'" ORDER BY job_internship_request.id DESC'
        );

    }

    public function applyJobInternship(\stdClass $job){
        return $this->insertObject('job_internship_request',$job);
    }

}