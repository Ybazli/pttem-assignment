<?php


    namespace App\Command;

    use App\Document\Product;
    use Doctrine\Bundle\MongoDBBundle\Command\DoctrineODMCommand;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class CreateProductCommand extends DoctrineODMCommand
    {
        protected static $defaultName = 'app:create-product';

        protected function configure()
        {

        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output->writeln([
                'Creating Dummy Data in DB!',
                'Please Wait...'
            ]);

            try {
                $this->createProducts();
                $output->write("<info>Done :)</info>");
            } catch (\Exception $e) {
                $output->write("<error>{$e}</error>");
            }

            return 0;
        }

        protected function createProducts()
        {
            $dm = $this->getManagerRegistry()->getManager();

            for ($i = 0; $i <= 1; $i++) {
                $product = new Product();
                $product->setName('product '.$i);
                $product->setDescription('There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.');
                $product->setProvider('ptt');
                $product->setAvailability(true);
                $product->setCategory('technology');
                $product->setImage('');
                $dm->persist($product);
            }
            $dm->flush();
        }

    }