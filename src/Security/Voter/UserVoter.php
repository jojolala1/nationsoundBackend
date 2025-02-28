<?php
namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    // Les actions possibles (DELETE dans ce cas)
    const DELETE = 'DELETE';

    protected function supports(string $attribute, $subject): bool
    {
        // Vérifie que l'action est DELETE et que l'objet est un utilisateur
        return in_array($attribute, [self::DELETE]) && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Si l'utilisateur n'est pas authentifié, il ne peut pas effectuer l'action
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Logique pour vérifier si l'utilisateur tente de se supprimer lui-même
        if ($attribute === self::DELETE) {
            // Empêche l'utilisateur de se supprimer lui-même
            if ($user === $subject) {
                return false;
            }

            // Empêche la suppression de certains profils (par exemple les administrateurs)
            if (in_array('ROLE_ADMIN', $subject->getRoles())) {
                return false;
            }
        }

        return true;
    }
}
