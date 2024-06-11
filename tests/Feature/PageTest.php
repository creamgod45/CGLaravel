<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Lib\I18N\ELanguageCode;
use App\Lib\Utils\RouteNameField;
use App\Lib\Utils\Utilsv2;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get(route(RouteNameField::PageHome->value));
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
    }

    public function test_the_application_forget_password_a_successful_response(): void
    {
        $response = $this->get(route(RouteNameField::PageForgetPassword->value));
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
    }

    public function test_the_application_passwordreset(): void
    {
        $response = $this->get(route(RouteNameField::PagePasswordReset->value));
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(302)
            ->assertRedirectToRoute(RouteNameField::PageHome->value)
            ->assertInvalid();
    }

    public function test_the_application_member(): void
    {
        $response = $this->get(route(RouteNameField::PageMembers->value));
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(302)
            ->assertRedirectToRoute('member.form-login');
    }

    public function test_the_application_lzstring_compare()
    {
        $value = "lzstring compress data to encode data post to lzstring.json URL deocde data to check";
        $compress = Utilsv2::encodeContext($value)['compress'];
        $response = $this->postJson(route(RouteNameField::APIEncodeJson->value), ['a' => $compress]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200)
            ->assertJson(['message' => 'Data received successfully', 'raw' => Utilsv2::decodeContext($compress)]);
    }

    public function test_the_application_language()
    {
        $response = $this->postJson(route(RouteNameField::APILanguage->value), ['lang' => ELanguageCode::zh_CN->name]);
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200)
            ->assertJson(['message' => 'Data received successfully', 'lang' => ELanguageCode::zh_CN->name]);
        $response = $this->postJson(route(RouteNameField::APILanguage->value), ['lang' => "error"]);
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(400)
            ->assertJson(['message' => 'Error']);
        $response = $this->postJson(route(RouteNameField::APILanguage->value));
        //$response->dumpHeaders();
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                //$json->dump();
                $json->hasAll(['message', 'lang']);
            });
    }

    public function test_the_application_member_middleware_testing()
    {
        // user tester
        $user = Member::factory()->create();

        $response = $this->actingAs($user, 'web')->get('/resendemail');
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(302)
            ->assertSessionHas('mail', true)
            ->assertRedirectToRoute(RouteNameField::PageHome->value);

        $response = $this->actingAs($user, 'web')->get(route(RouteNameField::PageLogout->value));
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200)
            ->assertViewIs('logout');

        // 已經驗證過信箱

        $user->markEmailAsVerified();

        $response = $this->actingAs($user, 'web')->get(route(RouteNameField::PageMembers->value));
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200)
            ->assertViewIs('members');

        $response = $this->actingAs($user, 'web')->get('/resendemail');
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(302)
            ->assertSessionHas('mail_result', 1)
            ->assertRedirectToRoute(RouteNameField::PageHome->value);

        $user->delete();
    }

    public function test_the_application_resendemail()
    {
        $response = $this->get('/resendemail');
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(302)
            ->assertRedirectToRoute('member.form-login');
    }
}
