<?php

namespace App\Controller\Admin;

use App\Entity\Cours;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;


class CoursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cours::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('type')
                ->setChoices(function () {
                    return ["TD" => "TD", "TP" => "TP", "Cours" => "Cours"];
                })
                ->renderAsNativeWidget(),
            DateTimeField::new('date_heure_debut')
                ->setFormat("dd/MM/YY HH:mm")
                ->renderAsChoice(),
            DateTimeField::new('dateHeureFin')
                ->setFormat("dd/MM/YY HH:mm")
                ->renderAsChoice(),
            AssociationField::new('professeur'),
            AssociationField::new('matiere'),
            AssociationField::new('salle'),
        ];
    }
}
