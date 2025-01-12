<?php

namespace App\Models;

use core\Model;

class AdminModel extends Model
{
    public function getCounts(){
        return $this->executeWithQuery('
                SELECT
                (SELECT COUNT(*) FROM users WHERE userType = "Alumni") AS alumni,
                (SELECT COUNT(*) FROM users WHERE userType = "Student") AS student,
                (SELECT COUNT(*) FROM job_internship) AS jobs,
                (SELECT COUNT(*) FROM mentorship) AS mentorship
            ');
    }

    public function getChartData(){
        return $this->executeWithQuery('
                SELECT 
                    event.event,
                    COUNT(DISTINCT event.id) AS event_count,
                    COUNT(event_participation.id) AS participation_count
                FROM 
                    event
                LEFT JOIN 
                    event_participation ON event.id = event_participation.event_id
                GROUP BY 
                    event.event;

            ');
    }

    public function generateReport(){
        return $this->executeWithQuery("
                SELECT 
            event.event AS event_name,
            event.date AS event_date,
            event.place AS event_place,
            GROUP_CONCAT(DISTINCT users.name SEPARATOR ', ') AS participant_names,
            CASE 
                WHEN COUNT(event_participation.email) > 0 THEN 'Yes'
                ELSE 'No'
            END AS participation
        FROM 
            event
        LEFT JOIN 
            event_participation ON event.id = event_participation.event_id 
        LEFT JOIN 
            users ON event_participation.email = users.email AND users.userType = 'Alumni'
        GROUP BY
            event.event, event.date, event.place
        ORDER BY 
            event.event, event.date;
        ");
    }

    public function getAlumniRewards(){
        return $this->executeWithQuery('
                    SELECT 
                a.name AS alumni_name,
                COUNT(DISTINCT ji.id) AS job_reward,
                COUNT(DISTINCT m.id) AS internship_reward,
                (COUNT(DISTINCT ji.id) + COUNT(DISTINCT m.id)) AS total_reward
            FROM 
                alumni a
            LEFT JOIN 
                job_internship ji ON a.id = ji.creater_id
            LEFT JOIN 
                mentorship m ON a.id = m.alumniId
            GROUP BY 
                a.id, a.name;
        ');
    }

}