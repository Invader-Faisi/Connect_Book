<?php

namespace App\Models;

use App\Core\Classes\Job_Internship;
use core\Model;

class JobModel extends Model
{
    public function getJobInternships(){
        return $this->selectAll('job_internship');
    }

    public function postJobInternship(Job_Internship $job_internship, $id = ''){
        if($id == ''){
            return $this->insertObject('job_internship',$job_internship);
        }else{
            return $this->updateObject('job_internship',$job_internship,$id);
        }

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

    public function getJobById($id){
        return $this->selectWhere('job_internship', ['id' => $id]);
    }

    public function deleteJobInternship($id){
        return $this->deleteWhere('job_internship',$id);
    }

}