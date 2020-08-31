<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Answer;
use App\Entity\Session;
use App\Entity\Category;
use App\Entity\Question;
use App\Repository\RoleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{    
    public function load(ObjectManager $manager)
    {
        //creat admin role
        $role = new Role();
        $role->setName('ROLE_ADMIN');
        $role->setCreatedAt(new \DateTime());
        $manager->persist($role);

        //create admin user for tests
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword('admin'); 
        $user->setEmail('admin'.'@morbol.com');
        $user->setIsEmailCheck(true);
        $user->setIsActive(true);
        $user->setFirstname('Monprénom');
        $user->setLastname('Monnom');
        $user->setUserRole($role);
        $user->setCreatedAt(new \DateTime());
        $manager->persist($user);

        // create categories
        $nuggets = new Category();
        $nuggets->setName("Nuggets");
        $nuggets->setCreatedAt(new \DateTime());
        $manager->persist($nuggets);
        $saltpepper = new Category();
        $saltpepper->setName("Sel ou poivre");
        $saltpepper->setCreatedAt(new \DateTime());
        $manager->persist($saltpepper);
        $menus = new Category();
        $menus->setName("Menus");
        $menus->setCreatedAt(new \DateTime());
        $manager->persist($menus);
        $sum = new Category();
        $sum->setName("L'addition");
        $sum->setCreatedAt(new \DateTime());
        $manager->persist($sum);
        $deathquiz = new Category();
        $deathquiz->setName("Morbol de la Mort");
        $deathquiz->setCreatedAt(new \DateTime());
        $manager->persist($deathquiz);
        
        // create test sessions
        $session1 = new Session();
        $session1->setName("Session test 1");
        $session1->setCreatedAt(new \DateTime());
        $session1->setUser($user);
        $manager->persist($session1);
        $session2 = new Session();
        $session2->setName("Session test 2");
        $session2->setCreatedAt(new \DateTime());
        $session2->setUser($user);
        $manager->persist($session2);

        // create menus for 2 sessions
        $menu1s1 = new Menu();
        $menu1s1->setName("Menu 1");
        $menu1s1->setMenuOrder(1);
        $menu1s1->setSession($session1);
        $menu1s1->setCreatedAt(new \DateTime());
        $manager->persist($menu1s1);

        $menu2s1 = new Menu();
        $menu2s1->setName("Menu 2");
        $menu2s1->setMenuOrder(2);
        $menu2s1->setSession($session1);
        $menu2s1->setCreatedAt(new \DateTime());
        $manager->persist($menu2s1);

        $menu3s1 = new Menu();
        $menu3s1->setName("Menu 3 qui est plus long en terme de titre");
        $menu3s1->setMenuOrder(3);
        $menu3s1->setSession($session1);
        $menu3s1->setCreatedAt(new \DateTime());
        $manager->persist($menu3s1);

        $menu1s2 = new Menu();
        $menu1s2->setName("Menu 1");
        $menu1s2->setMenuOrder(1);
        $menu1s2->setSession($session2);
        $menu1s2->setCreatedAt(new \DateTime());
        $manager->persist($menu1s2);

        $menu2s2 = new Menu();
        $menu2s2->setName("Menu 2");
        $menu2s2->setMenuOrder(2);
        $menu2s2->setSession($session2);
        $menu2s2->setCreatedAt(new \DateTime());
        $manager->persist($menu2s2);

        $menu3s2 = new Menu();
        $menu3s2->setName("Menu 3 qui est plus long en terme de titre");
        $menu3s2->setMenuOrder(3);
        $menu3s2->setSession($session2);
        $menu3s2->setCreatedAt(new \DateTime());
        $manager->persist($menu3s2);
        
        // create nuggets' questions and their answers    
        for ($i = 0; $i < 6; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText('Question '.$nb.' ?');
            $question->setOrderInNuggets($nb);
            $question->setCategory($nuggets);
            $question->setSession($session1);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
            for ($j = 0; $j < 4; $j++) {
                $nb = $j+1;
                $answer = new Answer();
                $answer->setText('Réponse '.$nb.'.');
                $answer->setAnswerOrder($nb);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);
            }  
        }  
        for ($i = 0; $i < 6; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText('Question '.$nb.' ?');
            $question->setOrderInNuggets($nb);
            $question->setCategory($nuggets);
            $question->setSession($session2);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
            for ($j = 0; $j < 4; $j++) {
                $nb = $j+1;
                $answer = new Answer();
                $answer->setText('Réponse '.$nb.'.');
                $answer->setAnswerOrder($nb);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);
            }  
        }

        // create salt and pepper's questions and their answers    
        for ($i = 0; $i < 10; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Ce truc est fait avec machin");
            $question->setOrderInSaltpepper($nb);
            $question->setCategory($saltpepper);
            $question->setSession($session1);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
                $answer = new Answer();
                $answer->setText("Réponse.");
                $answer->setAnswerOrder(1);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);  
        }
        for ($i = 0; $i < 10; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Ce truc est fait avec machin");
            $question->setOrderInSaltpepper($nb);
            $question->setCategory($saltpepper);
            $question->setSession($session2);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
                $answer = new Answer();
                $answer->setText("Réponse.");
                $answer->setAnswerOrder(1);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);  
        }

        // create menus' questions and their answers    
        for ($i = 0; $i < 5; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Question $nb ?");
            $question->setOrderInMenu($nb);
            $question->setCategory($menus);
            $question->setMenu($menu1s1);
            $question->setSession($session1);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
            for ($j = 0; $j < 4; $j++) {
                $nb = $j+1;
                $answer = new Answer();
                $answer->setText("Réponse $nb.");
                $answer->setAnswerOrder($nb);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);
            }  
        }  
        for ($i = 0; $i < 5; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Question $nb ?");
            $question->setOrderInMenu($nb);
            $question->setCategory($menus);
            $question->setMenu($menu2s1);
            $question->setSession($session1);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
            for ($j = 0; $j < 4; $j++) {
                $nb = $j+1;
                $answer = new Answer();
                $answer->setText("Réponse $nb.");
                $answer->setAnswerOrder($nb);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);
            }  
        }
        for ($i = 0; $i < 5; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Question $nb ?");
            $question->setOrderInMenu($nb);
            $question->setCategory($menus);
            $question->setMenu($menu3s1);
            $question->setSession($session1);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
            for ($j = 0; $j < 4; $j++) {
                $nb = $j+1;
                $answer = new Answer();
                $answer->setText("Réponse $nb.");
                $answer->setAnswerOrder($nb);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);
            }  
        }
        for ($i = 0; $i < 5; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Question $nb ?");
            $question->setOrderInMenu($nb);
            $question->setCategory($menus);
            $question->setMenu($menu1s2);
            $question->setSession($session2);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
            for ($j = 0; $j < 4; $j++) {
                $nb = $j+1;
                $answer = new Answer();
                $answer->setText("Réponse $nb.");
                $answer->setAnswerOrder($nb);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);
            }  
        }  
        for ($i = 0; $i < 5; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Question $nb ?");
            $question->setOrderInMenu($nb);
            $question->setCategory($menus);
            $question->setMenu($menu2s2);
            $question->setSession($session2);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
            for ($j = 0; $j < 4; $j++) {
                $nb = $j+1;
                $answer = new Answer();
                $answer->setText("Réponse $nb.");
                $answer->setAnswerOrder($nb);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);
            }  
        }
        for ($i = 0; $i < 5; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Question $nb ?");
            $question->setOrderInMenu($nb);
            $question->setCategory($menus);
            $question->setMenu($menu3s2);
            $question->setSession($session2);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
            for ($j = 0; $j < 4; $j++) {
                $nb = $j+1;
                $answer = new Answer();
                $answer->setText("Réponse $nb.");
                $answer->setAnswerOrder($nb);
                $answer->setQuestion($question);
                $answer->setIsCorrect((bool)random_int(0, 1)<0.5);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);
            }  
        }

        // create sum's questions and their answers    
        for ($i = 0; $i < 10; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Ce truc est fait avec machin ?");
            $question->setOrderInSum($nb);
            $question->setCategory($sum);
            $question->setSession($session1);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
                $answer = new Answer();
                $answer->setText("Réponse.");
                $answer->setAnswerOrder(1);
                $answer->setQuestion($question);
                $answer->setIsCorrect(true);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);  
        }
        for ($i = 0; $i < 10; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Ce truc est fait avec machin ?");
            $question->setOrderInSum($nb);
            $question->setCategory($sum);
            $question->setSession($session2);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
                $answer = new Answer();
                $answer->setText("Réponse.");
                $answer->setAnswerOrder(1);
                $answer->setQuestion($question);
                $answer->setIsCorrect(true);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);  
        }

        // create deathquiz's questions and their answers
        for ($i = 0; $i < 10; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Ce truc est fait avec machin ?");
            $question->setOrderInDeathquiz($nb);
            $question->setCategory($deathquiz);
            $question->setSession($session1);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
                $answer = new Answer();
                $answer->setText("Réponse.");
                $answer->setAnswerOrder(1);
                $answer->setQuestion($question);
                $answer->setIsCorrect(true);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);  
        }
        for ($i = 0; $i < 10; $i++) {
            $nb = $i+1;
            $question = new Question();
            $question->setText("Ce truc est fait avec machin ?");
            $question->setOrderInDeathquiz($nb);
            $question->setCategory($deathquiz);
            $question->setSession($session2);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
                $answer = new Answer();
                $answer->setText("Réponse.");
                $answer->setAnswerOrder(1);
                $answer->setQuestion($question);
                $answer->setIsCorrect(true);
                $answer->setCreatedAt(new \DateTime());
                $manager->persist($answer);  
        }




        $manager->flush();
    }
}
