<?php

namespace App\Command;

use App\Manager\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RemoveAdminCommand extends Command
{
    protected static $defaultName = 'app:remove-admin';

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
            ->setDescription('Remove admin rights for the specified user')
            ->addArgument('email', InputArgument::REQUIRED, 'Email of the user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        if ($email) {
            $user = $this->userManager->getUserByEmail($email);
            if($user) {
                $userRoles = $user->getRoles();
                if(in_array(self::ROLE_ADMIN, $userRoles)) {
                    $user->removeRole(self::ROLE_ADMIN);
                    $this->userManager->save($user);
                    $io->success(sprintf('The user %s is no longer an admin.', $user->getEmail()));
                } else {
                    $io->warning(sprintf('The user %s is not an admin! Nothing happened.', $user->getEmail()));
                }
            } else {
                $io->error('User not found. Be sure to give me the email of an existing user.');
            }
        }
    }
}
