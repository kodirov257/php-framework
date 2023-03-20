<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Init extends AbstractMigration
{
    public function change(): void
    {
        $this->table('posts')
            ->addColumn('date', 'datetime')
            ->addColumn('title', 'string')
            ->addColumn('content', 'text')
            ->create();
    }
}
