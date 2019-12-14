<?php

/**
 * Copyright (c) 2019 "Werner Maisl"
 *
 * This file is part of ForumUserAPI
 * Aurorastation-Wi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getStaff(Request $request, $role){
        //Fetch Staff List
        $query_data = ["groupid"=>intval($role)];

        $data = DB::select('SELECT * FROM view_userdata WHERE forum_primary_group = :groupid OR FIND_IN_SET(":groupid",forum_secondary_groups)', $query_data);

        return response()->json($data,200);
    }

    public function getDiscord(Request $request, $discord){
        $query_data = ["discordid"=>intval($discord)];

        $data = DB::select('SELECT * FROM view_userdata WHERE discord_id = :discordid', $query_data);

        return response()->json($data,200);
    }

    public function getCkey(Request $request, $ckey){
        //Convert to ckey
        $ckey = strtolower($ckey);
        $ckey = preg_replace('/[^a-z0-9]/', '', $ckey);

        $query_data=["ckey"=>$ckey];

        $data = DB::select('SELECT * FROM view_userdata WHERE ckey = :ckey',
            $query_data);


        return response()->json($data,200);
    }
}
