<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WhatsAppTemplateTest extends TestCase
{
    use RefreshDatabase;

    public function test_whatsapp_template_can_be_saved_per_wedding(): void
    {
        [$user, $weddingId] = $this->createWedding();
        $template = 'Halo {{nama_tamu}}, undangan {{nama_pasangan}}: {{link_undangan}}';

        $response = $this->actingAs($user)->putJson(
            route('wedding.tamu.whatsappTemplate.update', $weddingId),
            ['whatsapp_template' => $template]
        );

        $response->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('pernikahans', [
            'id' => $weddingId,
            'whatsapp_template' => $template,
        ]);
    }

    public function test_whatsapp_button_uses_saved_template_and_guest_placeholders(): void
    {
        [$user, $weddingId] = $this->createWedding(
            'Halo {{nama_tamu}} - {{nama_pasangan}} - {{link_undangan}}'
        );

        DB::table('tamus')->insert([
            'pernikahan_id' => $weddingId,
            'nama_tamu' => 'Siti',
            'no_telp' => '081234567890',
            'undangan_code' => 'INV-1-001',
            'status_hadir' => 'belum_konfirmasi',
            'jumlah_orang' => 1,
            'show_gift' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->getJson(
            route('wedding.tamu.getdata', $weddingId)
        );

        $response->assertOk();

        $message = 'Halo Siti - Budi & Ani - '.url('undangan/budi-ani/INV-1-001');
        $this->assertStringContainsString(
            rawurlencode($message),
            $response->json('data.0.action')
        );
    }

    private function createWedding(?string $whatsappTemplate = null): array
    {
        $roleId = DB::table('roles')->insertGetId([
            'name' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::forceCreate([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $roleId,
            'status' => 'active',
        ]);

        $pembeliId = DB::table('pembelis')->insertGetId([
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $layoutId = DB::table('layouts')->insertGetId([
            'nama_layout' => 'Layout 7',
            'folder_path' => 'layout7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $statusId = DB::table('status_pernikahans')->insertGetId([
            'nama_status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $weddingId = DB::table('pernikahans')->insertGetId([
            'pembeli_id' => $pembeliId,
            'nama_pria' => 'Budi',
            'nama_lengkap_pria' => 'Budi Santoso',
            'nama_wanita' => 'Ani',
            'nama_lengkap_wanita' => 'Ani Lestari',
            'tanggal' => '2026-12-20',
            'layout_id' => $layoutId,
            'masa_aktif' => '2027-01-20',
            'status_id' => $statusId,
            'slug' => 'budi-ani',
            'whatsapp_template' => $whatsappTemplate,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [$user, $weddingId];
    }
}
