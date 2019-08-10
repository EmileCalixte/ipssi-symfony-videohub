<?php

namespace App\Command;

use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddAdminCommand extends Command
{
    protected static $defaultName = 'app:add-admin';

    const ROLE_ADMIN = 'ROLE_ADMIN';

    private $userManager;

    public function __construct(UserManager $userManager, string $name = null)
    {
        $this->userManager = $userManager;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Set a user as admin or create a new admin user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        // Récupération de l'adresse email
        $emailQuestion = new Question('Enter the email address of the user to whom you want to grant admin rights: ');
        do {
            $userEmail = $helper->ask($input, $output, $emailQuestion);
            $userEmailIsValid = true;
            if(is_null($userEmail)) {
                $userEmailIsValid = false;
                $io->writeln('You must specify an email address!');
            } elseif(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                $userEmailIsValid = false;
                $io->writeln('This email address is not valid');
            }
        } while(!$userEmailIsValid);

        $user = $this->userManager->getUserByEmail($userEmail);

        // Si aucun utilisateur ne correspond à cette adresse email, on le crée
        if(is_null($user)) {
            $createUserQuestion = new ConfirmationQuestion('This user does not exist yet. Do you want to create it ? [y/n]', false);

            if(!$helper->ask($input, $output, $createUserQuestion)) {
                return;
            }

            // Récupération de l'adresse email
            $passwordQuestion = new Question('Create a password for this new admin user (be sur to not misstype): ');
            do {
                $userPassword = $helper->ask($input, $output, $passwordQuestion);
                $userPasswordIsValid = true;
                if(is_null($userPassword)) {
                    $userPasswordIsValid = false;
                    $io->writeln('You must specify a password!');
                }
            } while(!$userPasswordIsValid);

            // Récupération de la date de naissance
            $birthdayQuestion = new Question('And now, tell me what is the birthday of this admin (format: YYYY-MM-DD hh:ii:ss): ');
            do {
                $userBirthday = $helper->ask($input, $output, $birthdayQuestion);
                $userBirthdayIsValid = true;
                if(is_null($userBirthday)) {
                    $userBirthdayIsValid = false;
                    $io->writeln('You must specify a birthday!');
                }
                $birthday = \DateTime::createFromFormat('Y-m-d H:i:s', $userBirthday);
                if(!($birthday instanceof \DateTime)) {
                    $userBirthdayIsValid = false;
                    $io->writeln('The format you specified is not valid!');
                }
            } while(!$userBirthdayIsValid);

            $newUser = new User();
            $newUser->setEmail($userEmail);
            $newUser->setBirthday($birthday);
            // TODO continuer

        // Si l'utilisateur existe, on lui ajoute simplement le rôle
        } else {
            $userRoles = $user->getRoles();
            if(in_array(self::ROLE_ADMIN, $userRoles)) {
                $io->warning(sprintf('The user %s is already admin! Nothing happened.', $user->getEmail()));
                return;
            }

            $user->addRole(self::ROLE_ADMIN);
            $this->userManager->save($user);
            $io->success(sprintf('The user %s has now admin rights.', $user->getEmail()));
        }

    }
}
