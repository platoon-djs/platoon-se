<?php


/**
 * BookingController
 */
class BookingController extends BaseController
{

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Boka';
		$this->data['slug'] = 'booking';
	}

	public function index()
	{
		$this->render('@pages/booking.twig', [
			'recaptcha_sitekey' => getenv('RECAPTCHA_SITEKEY')
		]);
	}

	public function place($query)
	{
		$client = new \GuzzleHttp\Client();
		$response = $client->get('https://maps.googleapis.com/maps/api/place/autocomplete/json', [
			'query' => [
				'input' => $query,
				'language' => 'sv',
				'location' => '59.326142,17.9875454', // Stockholm
				'key' => getenv('GOOGLE_PLACEKEY')
			]
		]);

		echo $response->getBody();
	}

	protected function getEmail($__template__, $parameters)
	{
		$__template__ = VIEW_PATH . 'emails/' . $__template__;
		extract($parameters);

		ob_start();
		include $__template__;
		return ob_get_clean();
	}

	public function send()
	{
		$data = json_decode($this->app->request->getBody(), true);

		$name        = $data['name'];
		$email       = $data['email'];
		$phone       = $data['phone'];
		$event       = $data['event'];
		$date        = $data['date'];
		$timeFrom    = $data['timeFrom'];
		$timeTo      = $data['timeTo'];
		$place       = $data['place'];
		$sound       = $data['sound'];
		$light       = $data['light'];
		$setup       = $data['setup'];
		$renown      = $data['renown'];
		$description = isset($data['description']) ? '' : $data['description'];
		$captcha     = $data['captcha'];

		$valid = !empty($name);
		$valid = !$valid ? false : preg_match('/^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/', $email);
		$valid = !$valid ? false : preg_match('/^[\+0-9][0-9\s]*/', $phone);
		$valid = !$valid ? false : !empty($event);
		$valid = !$valid ? false : !empty($date);
		$valid = !$valid ? false : !empty($timeFrom);
		$valid = !$valid ? false : !empty($timeTo);
		$valid = !$valid ? false : !empty($place);
		$valid = !$valid ? false : !empty($sound);
		$valid = !$valid ? false : !empty($light);
		$valid = !$valid ? false : !empty($setup);
		$valid = !$valid ? false : !empty($renown);
		//$valid = !$valid ? false : !empty($description);
		$valid = !$valid ? false : !empty($captcha);

		if ($valid) {
			$data['date'] = preg_replace('/\//', '-', $date);
			$client = new \GuzzleHttp\Client();
			$response = $client->get('https://www.google.com/recaptcha/api/siteverify', [
				'query' => [
					'response' => $captcha,
					'secret' => getenv('RECAPTCHA_SERVERKEY')
				]
			]);

			if(empty($response)) {
				$valid = false;
			} else {
				$valid = json_decode($response->getBody())->success;
			}
		}

		if ($valid) {

			$mgClient = new \Mailgun\Mailgun(getenv('MAILGUN_APPKEY'));
			$domain = getenv('MAILGUN_DOMAIN');

			// Message to customer
			$mgClient->sendMessage($domain, [
				'from'    => getenv('BOOKING_FROM'),
				'to'      => "<{$data['email']}>",
				'subject' => 'Bokningsförfrågan - Platoon DJs',
				'text'    => "Vi har mottagit din förfrågan för bokning av DJ. Vi kommer höra av oss så snart vi kan för att hitta en anpassad offert till just ditt event.\n\n(OBS: Det här meddelandet går inte att svara på, hör av dig till <bokning@platoon.se> istället om det är några oklarheter)\n\n\nMVH//\nPlatoon DJs"
			]);

			// Message to customer relations
			$data['captcha'] = true;
			$result = $mgClient->sendMessage($domain, [
				'from'      => "{$data['name']} <{$data['email']}>",
				'to'      	=> getenv('BOOKING_TO'),
				'subject' 	=> "Bokningsförfrågan Platoon DJs: {$data['name']}, {$data['event']} i/på {$data['place']} {$data['date']}",
				'html' => $this->getEmail('e-request.php', $data)
			]);

			echo json_encode(compact('valid'/*, 'result'*/));
		} else {
			echo json_encode(compact('valid'));
		}
	}
	
}
