<?php

namespace TrelloBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CardsMovedsCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('trello:moved:card')
                ->setDescription("Verifica se existem novos cards movidos para a lista ou todas as listas configuradas")
                ->addOption(
                        'list', null, InputOption::VALUE_OPTIONAL, "Lista desejada");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->getLists($input) as $listId) {

            $output->writeln("Getting for $listId ...");

            $cards = $this->getContainer()->get('trello.card.moved')->getMovedCardsByList($listId);

            foreach ($cards as $card) {
                $this->getContainer()->get('trello.card.moved')->registerNewCardMoved($card);
            }
        }
    }

    public function getLists(InputInterface $input)
    {
        return $this->getContainer()->get('trello.lists')->getIdListBy($input->getOption('list'));
    }

}
