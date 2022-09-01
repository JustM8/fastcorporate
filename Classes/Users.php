<?php
namespace Classes;

use PDO;

class Users
{
    public array $activityArray = [];

    public function registerUser(array $data)
    {
        $login = $data['dataF'][0]['value'];
        $password = md5($data['dataF'][1]['value']);
        $role = 'user';
        $date = date("Y-m-d");


        $query = Db::pdo()->prepare("INSERT INTO users (login, role, password, register_date) VALUES (:login, :role, :password,:register_date)");

        $query->bindParam("login", $login);
        $query->bindParam("role", $role);
        $query->bindParam("password", $password);
        $query->bindParam("register_date", $date);
        $query->execute();

        return Db::pdo()->lastInsertId();
    }

    public function login(array $data)
    {

        $login = $data['dataF'][0]['value'];
        $password = md5($data['dataF'][1]['value']);

        $query = Db::pdo()->prepare("SELECT * FROM users WHERE login = :login");
        $query->bindParam('login', $login);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result['password'] == $password) {

            $_SESSION['auth'] = true;
            $_SESSION['uid'] = $result['id'];
            $_SESSION['login'] = $result['login'];
            $_SESSION['role'] = $result['role'];

            return  $result['id'];
        } else {
            echo false;
        }

    }

    public function logout(): bool
    {
        return session_destroy();
    }

    public function checkReportsActivity($id, $type,$date)
    {
        $activity_types = [
            'view page A'=>'count_a',
            'view page B'=>'count_b',
            'button click'=>'count_click',
            'download file'=>'count_download',
            ];
        $activity_type = $activity_types[$type];

        $query = Db::pdo()->prepare("SELECT * FROM activity WHERE user_id = :user_id AND activity_date = :activity_date AND $activity_type=$activity_type");
        $query->bindParam("user_id", $id);
        $query->bindParam("activity_date", $date);

        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function reportsActivity($id, $type): bool
    {
        $activity_types = [
            'view page A'=>'count_a',
            'view page B'=>'count_b',
            'button click'=>'count_click',
            'download file'=>'count_download',
        ];
        $activity_type = $activity_types[$type];
        $date = date("Y-m-d");
        $check = $this->checkReportsActivity($id, $type,$date);



        if (empty($check)) {
            $count = 1;

            $query = Db::pdo()->prepare("INSERT INTO activity (user_id, activity_date, $activity_type) VALUES (:user_id, :activity_date,:$activity_type)");

            $query->bindParam("user_id", $id, PDO::PARAM_INT);
            $query->bindParam($activity_type, $count);
            $query->bindParam("activity_date", $date);

        } else {
            $count = $check[$activity_type] + 1;

            $query = Db::pdo()->prepare("UPDATE activity SET $activity_type=:$activity_type WHERE user_id = :user_id AND activity_date = :activity_date");

            $query->bindParam("user_id", $id, PDO::PARAM_INT);
            $query->bindParam("activity_date", $date);
            $query->bindParam($activity_type, $count);

        }
        return $query->execute();
    }

    public function getReportsActivity($id): array
    {
        $query = Db::pdo()->prepare("SELECT activity_date,count_a,count_b,count_click,count_download  FROM activity;");
//        $query->bindParam('id', $id);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function sortActivity($id):string
    {
        $data = $this->getReportsActivity($id);
        $result = array(
            array('Date', 'page view A', ' page view B', 'click “Buy a cow“', 'click "Download"'),
        );
        foreach ($data as $value)
        {
            $result[] = array_values($value);
        }
        return json_encode(array_values($result));
    }

    public function createTable():string
    {

        $query = Db::pdo()->prepare("SELECT activity.activity_date,activity.count_a,activity.count_b,activity.count_click,activity.count_download, users.login  
                                           FROM activity 
                                           LEFT JOIN users on activity.user_id=users.id;");
        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $result = ' <tr>
    <th scope="col">Date</th>
    <th scope="col">page view A</th>
    <th scope="col">page view B</th>
    <th scope="col">click “Buy a cow“</th>
    <th scope="col">click "Download"</th>
    <th scope="col">User</th>
  </tr>';
         foreach($data as $rows){
                $result .= "<tr>".
                    "<td>".$rows['activity_date']."</td>".
                    "<td>".$rows['count_a']."</td>".
                    "<td>".$rows['count_b']."</td>".
                    "<td>".$rows['count_click']."</td>".
                    "<td>".$rows['count_download']."</td>".
                    "<td>".$rows['login']."</td>".
                    "</tr>";
         }
        return $result;
    }

    public function getUsersActivity($sort)
    {
        switch ($sort){
            case 'userSort':
                $query = Db::pdo()->prepare("SELECT * FROM user_activity ORDER BY user_id;");
            break;
            case 'dateSort':
                $query = Db::pdo()->prepare("SELECT * FROM user_activity ORDER BY activity_date;");
            break;
            default:
                $query = Db::pdo()->prepare("SELECT * FROM user_activity;");
            break;
        }

        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $userSort = 'onclick="sortTable("userSort")"';
        $result = '<tr>
    <th scope="col" id="userSort">User ID</th>
    <th scope="col" id="dateSort">Date</th>
    <th scope="col">Activity Type</th>
  </tr>';
        foreach($data as $rows){
            $result .= "<tr>".
                "<td>".$rows['user_id']."</td>".
                "<td>".$rows['activity_date']."</td>".
                "<td>".$rows['activity_type']."</td>".
                "</tr>";
        }
        return $result;
    }

    public function addUserActivity($id,$type):bool
    {
        $date = date("Y-m-d H:i:s");
        $query = Db::pdo()->prepare("INSERT INTO user_activity (activity_date, activity_type, user_id) VALUES (:activity_date, :activity_type, :user_id)");

        $query->bindParam("activity_date", $date);
        $query->bindParam("activity_type", $type);
        $query->bindParam("user_id", $id);

        return $query->execute();
    }
}
