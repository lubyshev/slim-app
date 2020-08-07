<?php
declare(strict_types=1);

use \App\Db\Migration;

final class GeoTestMigration extends Migration
{
    public function change(): void
    {
        $table = $this->table('geo_points');
        $table
            ->addColumn('central', 'point')
            ->addColumn('upper_left', 'point')
            ->addColumn('upper_right', 'point')
            ->addColumn('bottom_left', 'point')
            ->addColumn('bottom_right', 'point')
            ->create();
    }
}
