<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[AsCommand(
    name: 'app:add-user',
    description: 'Create user',
)]
class AddUserCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordEncoder $encoder;
    private UserRepository $userRepository;

    public function __construct(string $name = null, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
    }

    protected function configure(): void
    {
        $this
            ->addOption('email', 'em',InputArgument::REQUIRED, 'Email')
            ->addOption('password', 'pa',InputArgument::REQUIRED, 'Password')
            ->addOption('isAdmin', '',InputArgument::OPTIONAL, 'If set the user is created as an administrator', 0)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getOption('email');
        $password = $input->getOption('password');
        $isAdmin = $input->getOption('isAdmin');

        $io->title('Add User Command');
        $io->text([
            'Please enter some information'
        ]);
        // если не указан email
        if (!$email) {
            $email = $io->ask('Email');
        }

        //если пользователь не указал пороль
        if (!$password) {
            $password = $io->askHidden('Password (your type will be hidden)');
        }

        // если admin?
        if (!$isAdmin) {
            $question = new Question('Is admin (1 or 0)', 0);
            $isAdmin = $io->askQuestion($question);
        }
        $isAdmin = (bool)$isAdmin;
        try {
            $user = $this->createUser($email, $password, $isAdmin);
        } catch (RuntimeException $exception) {
            $io->comment($exception->getMessage());

            return Command::FAILURE;
        }
        //процедура по формированию пользователя


        //dd($email, $password, $isAdmin );
        $successMessage = sprintf('%s was successfully created : %s',
            $isAdmin ? 'Administrator User' : 'User',
            $email);

        $io->success($successMessage);

        return Command::SUCCESS;

    }

    /**
     * @param string $email
     * @param string $password
     * @param bool $isAdmin
     * @return User
     */
    private function createUser(string $email, string $password, bool $isAdmin): User
    {
        $existingUser = $this->userRepository->findOneBy(['email' => $email]);

        if ($existingUser) {
            throw new RuntimeException('User already exist');
        }

        $user = new User();
        $user->setEmail($email);
        $user->setRoles([$isAdmin ? 'ROLE_ADMIN' : 'ROLE_USER']);

        $encodedPassword = $this->encoder->encodePassword($user,$password);
        $user->setPassword($encodedPassword);


        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();;


        return $user;
    }


}
