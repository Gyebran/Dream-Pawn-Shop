<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
class AdminBackendTest extends TestCase {
 use RefreshDatabase;
 private function createRoleUser(string $role): User {
  $now=now();$id=DB::table('users')->insertGetId(['name'=>'Test '.ucfirst($role),'email'=>$role.'-test@example.test','password'=>Hash::make('secret-password'),'role'=>$role,'is_active'=>true,'created_at'=>$now,'updated_at'=>$now]);
  DB::table($role==='admin'?'admins':'members')->insert(['user_id'=>$id]);
  return User::findOrFail($id);
 }
 public function test_admin_dashboard_requires_authentication(): void { $this->getJson('/admin/dashboard')->assertUnauthorized(); }
 public function test_member_cannot_access_admin_dashboard(): void { $this->actingAs($this->createRoleUser('member'))->getJson('/admin/dashboard')->assertForbidden(); }
 public function test_admin_can_create_and_list_categories(): void {
  $this->actingAs($this->createRoleUser('admin'))->postJson('/admin/categories',['name'=>'Relics','description'=>'Fantasy props'])->assertCreated()->assertJsonPath('data.name','Relics');
  $this->getJson('/admin/categories')->assertOk()->assertJsonFragment(['name'=>'Relics']);
 }
 public function test_admin_login_rejects_member_account(): void {
  $this->createRoleUser('member');
  $this->postJson('/admin/login',['email'=>'member-test@example.test','password'=>'secret-password'])->assertForbidden();
 }
 public function test_admin_login_succeeds_for_admin_account(): void {
  $this->createRoleUser('admin');
  $this->postJson('/admin/login',['email'=>'admin-test@example.test','password'=>'secret-password'])->assertOk()->assertJsonPath('user.role','admin');
 }
}