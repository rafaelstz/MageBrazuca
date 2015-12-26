<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\DBAL\Exception\ServerException;
use Intervention\Image\ImageManagerStatic;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class UserService extends AbstractService
{
    const USER_IMAGE_FOLDER    = 'web/user/image';
    const USER_IMAGE_EXTENSION = 'jpg';

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Validator
     */
    private $validator;

    public function __construct(
        UserRepository $repository,
        Container $container,
        ValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->container  = $container;
        $this->validator  = $validator;
    }

    public function create(
        $firstname,
        $lastname,
        $email,
        $username,
        $password,
        $about,
        $picture,
        $location,
        $locationCityShort,
        $locationCityLong,
        $locationStateShort,
        $locationStateLong,
        $locationCountryShort,
        $locationCountryLong,
        $gender,
        $company,
        $isAvailableToHiring,
        $contactWebsite,
        $contactTwitter,
        $contactLinkedIn,
        $contactCertification,
        $contactGitHub,
        $contactStackOverflow
    ) {

        if (
            $errors = $this->getErrors(
                $firstname,
                $lastname,
                $email,
                $username,
                $password,
                $about,
                $locationCityShort,
                $locationCityLong,
                $locationStateShort,
                $locationStateLong,
                $locationCountryShort,
                $locationCountryLong,
                $gender,
                $company,
                $isAvailableToHiring
            )
        ) {
            throw new ServiceException($errors);
        }

        $user = new User();

        $user->setUsername($username);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword(md5($password));
        $user->setAbout($about);
        $user->setLocation($location);
        $user->setLocationCityShort($locationCityShort);
        $user->setLocationCityLong($locationCityLong);
        $user->setLocationStateShort($locationStateShort);
        $user->setLocationStateLong($locationStateLong);
        $user->setLocationCountryShort($locationCountryShort);
        $user->setLocationCountryLong($locationCountryLong);
        $user->setGender($gender);
        $user->setCompany($company);
        $user->setIsAvailableToHiring($isAvailableToHiring);
        $user->setContactWebsite($contactWebsite);
        $user->setContactTwitter($contactTwitter);
        $user->setContactLinkedIn($contactLinkedIn);
        $user->setContactCertification($contactCertification);
        $user->setContactGitHub($contactGitHub);
        $user->setContactStackOverflow($contactStackOverflow);
        $user->setCreatedAt(new \DateTime);

        if ($picture) {
            $user->setPicturePath(
                $this->moveImageFromTmpToFolder($picture)
            );
        }

        return $this->repository->create($user);
    }

    public function update(
        User $user,
        $firstname,
        $lastname,
        $email,
        $username,
        $password,
        $about,
        $picture,
        $location,
        $locationCityShort,
        $locationCityLong,
        $locationStateShort,
        $locationStateLong,
        $locationCountryShort,
        $locationCountryLong,
        $gender,
        $company,
        $isAvailableToHiring,
        $contactWebsite,
        $contactTwitter,
        $contactLinkedIn,
        $contactCertification,
        $contactGitHub,
        $contactStackOverflow
    ) {

        if (
            $errors = $this->getErrors(
                $firstname,
                $lastname,
                $email,
                $username,
                $password,
                $about,
                $locationCityShort,
                $locationCityLong,
                $locationStateShort,
                $locationStateLong,
                $locationCountryShort,
                $locationCountryLong,
                $gender,
                $company,
                $isAvailableToHiring,
                true,
                $password == '' ? false : true
            )
        ) {
            throw new ServiceException($errors);
        }

        $user->setUsername($username);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setAbout($about);
        $user->setLocation($location);
        $user->setLocationCityShort($locationCityShort);
        $user->setLocationCityLong($locationCityLong);
        $user->setLocationStateShort($locationStateShort);
        $user->setLocationStateLong($locationStateLong);
        $user->setLocationCountryShort($locationCountryShort);
        $user->setLocationCountryLong($locationCountryLong);
        $user->setGender($gender);
        $user->setCompany($company);
        $user->setIsAvailableToHiring($isAvailableToHiring);
        $user->setContactWebsite($contactWebsite);
        $user->setContactTwitter($contactTwitter);
        $user->setContactLinkedIn($contactLinkedIn);
        $user->setContactCertification($contactCertification);
        $user->setContactGitHub($contactGitHub);
        $user->setContactStackOverflow($contactStackOverflow);
        $user->setUpdatedAt(new \DateTime);

        if ($picture) {
            $user->setPicturePath(
                $this->moveImageFromTmpToFolder($picture)
            );
        }

        if ($password) {
            $user->setPassword(md5($password));
        }

        return $this->repository->create($user);
    }

    public function getErrors(
        $firstname,
        $lastname,
        $email,
        $username,
        $password,
        $about,
        $locationCityShort,
        $locationCityLong,
        $locationStateShort,
        $locationStateLong,
        $locationCountryShort,
        $locationCountryLong,
        $gender,
        $company,
        $isAvailableToHiring,
        $isUpdate = false,
        $validatePassword = true
    ) {
        $validator = $this->validator;

        $errors = array();

        $firstnameValidation = $validator->validateValue($firstname, array(
            new Constraints\NotBlank(),
            new Constraints\Length(array(
                'min' => 2,
                'max' => 45,
            )),
        ));

        if ($firstnameValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo Nome';
        }

        $lastnameValidation = $validator->validateValue($lastname, array(
            new Constraints\NotBlank(),
            new Constraints\Length(array(
                'min' => 2,
                'max' => 45,
            )),
        ));

        if ($lastnameValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo Sobrenome';
        }

        $emailValidation = $validator->validateValue($email, array(
            new Constraints\NotBlank(),
            new Constraints\Email(),
        ));

        if ($emailValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo Email';
        }

        $usernameValidation = $validator->validateValue($username, array(
            new Constraints\NotBlank(),
            new Constraints\Length(array(
                'min' => 4,
                'max' => 45,
            )),
            new Constraints\Regex(array(
                'pattern' => '/^[a-z0-9_]+$/i',
            )),
        ));

        if ($usernameValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo Usuário';
        }

        if ($validatePassword) {
            $passwordValidation = $validator->validateValue($password, array(
                new Constraints\NotBlank(),
                new Constraints\Length(array(
                    'min' => 4,
                    'max' => 45,
                )),
            ));

            if ($passwordValidation->count()) {
                $errors[] = 'Por favor, digite corretamente o campo Senha';
            }
        }

        $aboutValidation = $validator->validateValue($about, array(
            new Constraints\Length(array(
                'max' => 140,
            )),
        ));

        if (!$aboutValidation) {
            $errors[] = 'Por favor, digite corretamente o campo Sobre Você';
        }

        $locationCityShortValidation = $validator->validateValue($locationCityShort, array(
            new Constraints\NotBlank(),
        ));

        if ($locationCityShortValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo Cidade (campo abreviado)';
        }

        $locationCityLongValidation = $validator->validateValue($locationCityLong, array(
            new Constraints\NotBlank(),
            new Constraints\Length(array(
                'min' => 2,
                'max' => 45,
            )),
        ));

        if ($locationCityLongValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo Cidade (campo longo)';
        }

        $locationStateShortValidation = $validator->validateValue($locationStateShort, array(
            new Constraints\NotBlank(),
        ));

        if ($locationStateShortValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo Estado (campo abreviado)';
        }

        $locationStateLongValidation = $validator->validateValue($locationStateLong, array(
            new Constraints\NotBlank(),
        ));

        if ($locationStateLongValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo Estado (campo longo)';
        }

        $locationCountryShortValidation = $validator->validateValue($locationCountryShort, array(
            new Constraints\NotBlank(),
        ));

        if ($locationCountryShortValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo País (campo abreviado)';
        }

        $locationCountryLongValidation = $validator->validateValue($locationCountryLong, array(
            new Constraints\NotBlank(),
        ));

        if ($locationCountryLongValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo País (campo longo)';
        }

        $genderValidation = $validator->validateValue($gender, array(
            new Constraints\NotBlank(),
            new Constraints\Choice(array(
                User::GENDER_MALE,
                User::GENDER_FEMALE,
            ))
        ));

        if ($genderValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo Sexo';
        }

        $companyValidation = $validator->validateValue($company, array(
            new Constraints\Length(array(
                'max' => 140,
            )),
        ));

        if (!$companyValidation) {
            $errors[] = 'Por favor, digite corretamente o campo Empresa';
        }

        $isAvailableToHiringValidation = $validator->validateValue($isAvailableToHiring, array(
            new Constraints\NotBlank(),
            new Constraints\Choice(array(0, 1))
        ));

        if ($isAvailableToHiringValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo "Está disponível para contratação?"';
        }

        if (
               !$isUpdate
            && $this->repository->hasGivenUsernameAndEmail($username, $email)
        ) {
            $errors[] = 'O usuário ou email já existem.';
        }

        if ($errors) {
            return $errors;
        }

        return false;
    }

    public function moveImageFromTmpToFolder(UploadedFile $file) {
        $oldFilePath = $file->getPathname();

        $filename = uniqid() . uniqid();

        // default size
        $defaultPath = $this->getImagePath($filename);

        ImageManagerStatic::make($oldFilePath)
            ->save($defaultPath);


        // small size
        $smallPath = $this->getImagePath($filename, 'small');

        ImageManagerStatic::make($oldFilePath)
            ->resize(50, 50)
            ->save($smallPath);


        // medium-1 size
        $medium1Path = $this->getImagePath($filename, 'medium-1');

        ImageManagerStatic::make($oldFilePath)
            ->resize(90, 90)
            ->save($medium1Path);


        // medium-2 size
        $medium2Path = $this->getImagePath($filename, 'medium-2');

        ImageManagerStatic::make($oldFilePath)
            ->resize(150, 150)
            ->save($medium2Path);


        // large size
        $largePath = $this->getImagePath($filename, 'large');

        ImageManagerStatic::make($oldFilePath)
            ->resize(500, 500)
            ->save($largePath);


        unlink($oldFilePath);

        return $filename;
    }

    public function getImagePath($filename, $size = 'default')
    {
        return sprintf(
            '%s/%s/%s-%s.%s',
            $this->container->getParameter('base_path'),
            self::USER_IMAGE_FOLDER,
            $filename,
            $size,
            self::USER_IMAGE_EXTENSION
        );
    }

    public function login(
        $username,
        $password,
        $isPasswordEncrypted = false
    ) {
        if ($isPasswordEncrypted) {
            $user = $this->getUserByUsernameAndPassword(
                $username,
                $password
            );
        } else {
            $user = $this->getUserByUsernameAndPassword(
                $username,
                md5($password)
            );
        }

        if ($user) {
            $this
                ->container
                ->get('request')
                ->getSession()
                ->set('user_id', $user->getId());

            return true;
        }

        return false;
    }

    public function logout()
    {
        $this
            ->container
            ->get('request')
            ->getSession()
            ->remove('user_id');
    }

    public function getUserByUsernameAndPassword(
        $username,
        $password
    ) {
        return $this->repository->getUserByUsernameAndPassword(
            $username,
            $password
        );
    }

    public function findByUsername($username) {
        return $this->repository->findByUsername($username);
    }

    public function getTop() {
        /**
         * @TODO: FIX IT
         * I don't know WHY but I couldn't add the upvoteTotal in the UserEntity...
         * THUS, I have done a workaround thought out RAW SQL
         */

        $result = $this->repository->getTop();

        $data = array();

        foreach ($result as $row) {
            $user = new User();

            $user->setId($row['id']);
            $user->setFirstname($row['firstname']);
            $user->setLastname($row['lastname']);
            $user->setUsername($row['username']);
            $user->setPicturePath($row['picture_path']);
            $user->setUpvoteTotal($row['upvote_total']);

            $data[] = $user;
        }

        return $data;
    }
}
