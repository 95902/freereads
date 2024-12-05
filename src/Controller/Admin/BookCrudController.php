<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait;

    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         DateTimeField::new('createdAt', 'Creation Date')
    //             ->setFormat('yyyy-MM-dd HH:mm:ss'),
    //     ];
    // }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextField::new('subtitle'),
            TextEditorField::new('description'),
            TextField::new('isbn10'),
            TextField::new('isbn13'),
            ImageField::new('smallThumbail'),
            ImageField::new('thumbail'),
            CollectionField::new('authors'),
            CollectionField::new('publishers'),
            TextField::new('googleBooksId'),
        ];
    }
}
