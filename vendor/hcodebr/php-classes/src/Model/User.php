<?php
    namespace Hcode\Model;
    use Hcode\DB\Sql;
    use Hcode\Model;

    class User extends Model{
        
        const SESSION = "User";

        public static function login($login,$password)
        {
            $sql = new Sql();

            $result = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
                ":LOGIN"=>$login
            ));

            if (count($result) === 0) {
                throw new \Exception("Usuário ou senha inválida");
                
            }

            $data = $result[0];


           if ( password_verify($password,$data["despassword"])) {
                $user = new User();
                $user->setData($data);

                $_SESSION[User::SESSION] = $user->getValues();

                

             

           }else{
            throw new \Exception("Usuário ou senha inválida");
           }

        }

        public  static function verifyLogin($inadmin = true)
        {
            
            if (!isset($_SESSION[User::SESSION])  || (bool)$_SESSION['User']['inadmin'] === "inadmin") 
            {
              header("location: admin/login");
              exit;
              
            }
        }

        public static function logOut()
        {
            $_SESSION['User'] = NULL;
            header('Location: ./login');
            exit;
        }


    }


?>