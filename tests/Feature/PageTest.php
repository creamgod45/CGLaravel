<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Events\Notification;
use App\Jobs\BroadcastMessageJob;
use App\Lib\I18N\ELanguageCode;
use App\Lib\Utils\RouteNameField;
use App\Lib\Utils\Utilsv2;
use App\Models\Member;
use Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;
use Tests\TestCase;
use Ratchet\Client\WebSocket;
use Ratchet\Client\Connector;
use React\EventLoop\Factory;
use React\Socket\Connector as ReactConnector;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public string $cache_Notification_value = "";

    /**
     * A basic test example.
     */
    public function test_the_application_PageHome_returns_a_successful_response(): void
    {
        $response = $this->get(route(RouteNameField::PageHome->value));
        $response->assertStatus(200);
    }

    public function test_the_application_PageDesignComponents_returns_a_successful_response(): void
    {
        $response = $this->get(route(RouteNameField::PageDesignComponents->value));
        $response->assertStatus(200);
    }

    public function test_the_application_broadcast_returns_a_successful_response(): void
    {
        $response = $this->postJson(route(RouteNameField::APIBroadcast->value), ["description" => 'test', "title" => 'test', "type" => 'info', "second" => '10000',]);
        $response->assertStatus(200)->assertJson(function (AssertableJson $json) {
            $json->hasAll(['message', 'raw']);
        });
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
        $response->assertStatus(302)->assertRedirectToRoute(RouteNameField::PageHome->value)->assertInvalid();
    }

    public function test_the_application_member(): void
    {
        $response = $this->get(route(RouteNameField::PageMembers->value));
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(302)->assertRedirectToRoute(RouteNameField::PageLogin->value);
    }

    public function test_the_application_APIEncodeJson_compare()
    {
        $value = "lzstring compress data to encode data post to lzstring.json URL deocde data to check";
        $compress = Utilsv2::encodeContext($value)['compress'];
        $response = $this->postJson(route(RouteNameField::APIEncodeJson->value), ['a' => $compress]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200)->assertJson(['message' => 'Data received successfully', 'raw' => Utilsv2::decodeContext($compress)]);
    }

    public function test_the_application_language()
    {
        $response = $this->postJson(route(RouteNameField::APILanguage->value), ['lang' => ELanguageCode::zh_CN->name]);
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200)->assertJson(['message' => 'Data received successfully', 'lang' => ELanguageCode::zh_CN->name]);
        $response = $this->postJson(route(RouteNameField::APILanguage->value), ['lang' => "error"]);
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(400)->assertJson(['message' => 'Error']);
        $response = $this->postJson(route(RouteNameField::APILanguage->value));
        //$response->dumpHeaders();
        $response->assertStatus(200)->assertJson(function (AssertableJson $json) {
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
        $response->assertStatus(302)->assertSessionHas('mail', true)->assertRedirectToRoute(RouteNameField::PageHome->value);

        $response = $this->actingAs($user, 'web')->get(route(RouteNameField::PageLogout->value));
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200)->assertViewIs('logout');

        // 已經驗證過信箱

        $user->markEmailAsVerified();

        $response = $this->actingAs($user, 'web')->get(route(RouteNameField::PageMembers->value));
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200)->assertViewIs('members');

        $response = $this->actingAs($user, 'web')->get('/resendemail');
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(302)->assertSessionHas('mail_result', 1)->assertRedirectToRoute(RouteNameField::PageHome->value);

        $user->delete();
    }

    public function test_the_application_resendemail()
    {
        $response = $this->get('/resendemail');
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(302)->assertRedirectToRoute(RouteNameField::PageLogin->value);
    }

    public function test_the_Pusher_Broadcast_RX_TX()
    {

        $loop = Factory::create();
        $reactConnector = new ReactConnector($loop);
        $connector = new Connector($loop, $reactConnector);

        $connector('wss://ws-ap1.pusher.com:443/app/'.Config::get("broadcasting.connections.pusher.key").'?protocol=7&client=js&version=8.4.0-rc2&flash=false')
            ->then(function(WebSocket $conn) use($loop) {
                echo "Connected to Pusher WebSocket\n";

                $conn->on('message', function($msg) use ($conn, $loop) {
                    Log::info('test02_the_Pusher_Broadcast_Receive $conn->on:' . $msg);
                    echo "Received: {$msg}\n";
                    $data = json_decode($msg, true);
                    Log::info('test02_the_Pusher_Broadcast_Receive $data:' . $msg);


                    if (isset($data['event']) && $data['event'] == 'pusher_internal:subscription_succeeded') {
                        event(new Notification([
                            "test",
                            "test",
                            "info",
                            "10000",
                        ]));
                        Artisan::call("broadcast:Notification test test info 10000");
                        $output = Artisan::output();
                        Log::info("Artisan::output ".$output);
                    }

                    // 订阅频道
                    if (isset($data['event']) && $data['event'] == 'pusher:connection_established') {
                        Log::info('test02_the_Pusher_Broadcast_Receive $conn->send');
                        $conn->send(json_encode([
                            'event' => 'pusher:subscribe',
                            'data' => [
                                'channel' => 'Notification',
                            ],
                        ]));
                    }

                    // 处理自定义事件
                    if (isset($data['event']) && $data['event'] == 'Notification') {
                        Log::info('test02_the_Pusher_Broadcast_Receive $conn->RX:'.$msg);
                        echo "Message: " . $msg . "\n";
                        //var_dump($data);
                        $datadata = json_decode($data['data'], true);
                        //var_dump($datadata);
                        if(
                            $datadata['description'] === "test" &&
                            $datadata['title'] === "test" &&
                            $datadata['type'] === "info" &&
                            $datadata['second'] === "10000"){
                            $this->assertTrue(true);
                            $loop->stop();
                            Log::info('test02_the_Pusher_Broadcast_Receive loop end');
                        }else{
                            $this->fail("內容與不符合測試結果");
                        }
                    }
                    Log::info('test02_the_Pusher_Broadcast_Receive looping');
                });

                $conn->on('close', function($code = null, $reason = null) use($loop) {
                    Log::info('test02_the_Pusher_Broadcast_Receive loop end'."Connection closed ($code - $reason)\n");
                    echo "Connection closed ($code - $reason)\n";
                    $this->assertTrue(false);
                    $loop->stop();
                    Log::info('test02_the_Pusher_Broadcast_Receive loop end');
                });

            }, function(\Exception $e) use ($loop) {
                echo "Could not connect: {$e->getMessage()}\n";
                $loop->stop();
            });

        $loop->run();
    }

}
