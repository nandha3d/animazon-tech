<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlSlugToProposalsTable extends Migration
{
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            if (!Schema::hasColumn('proposals', 'url_slug')) {
                $table->string('url_slug')->nullable()->unique()->after('proposal_id');
            }
        });

        // Set 'rudra-spirit-hosting' as default branded slug for existing rudra proposal
        $proposals = \App\Models\Proposal::all();
        foreach ($proposals as $prop) {
            $customer = \App\Models\Customer::find($prop->customer_id);
            if ($prop->id == 1 || $prop->proposal_id == 1 || ($customer && stripos($customer->name, 'rudra') !== false)) {
                $prop->url_slug = 'rudra-spirit-hosting';
            } else {
                $prop->url_slug = 'proposal-' . $prop->proposal_id . '-' . strtolower(\Illuminate\Support\Str::random(6));
            }
            $prop->save();
        }
    }

    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            if (Schema::hasColumn('proposals', 'url_slug')) {
                $table->dropColumn('url_slug');
            }
        });
    }
}
