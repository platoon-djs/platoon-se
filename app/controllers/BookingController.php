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

	public function send()
	{
		$data = json_decode($this->app->request->getBody(), true);

		$name        = $data['name'];
		$email       = $data['email'];
		$event       = $data['event'];
		$date        = $data['date'];
		$place       = $data['place'];
		$description = $data['description'];
		$captcha     = $data['captcha'];

		$valid = !empty($name);
		$valid = !$valid ? false : preg_match('/^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/', $email);
		$valid = !$valid ? false : !empty($event);
		$valid = !$valid ? false : !empty($date);
		$valid = !$valid ? false : !empty($place);
		$valid = !$valid ? false : !empty($description);
		$valid = !$valid ? false : !empty($captcha);

		if ($valid) {
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

			$mgClient->sendMessage($domain, array(
				'from'    => getenv('BOOKING_FROM'),
				'to'      => "<{$data['email']}>",
				'subject' => 'Bokningsförfrågan - Platoon DJs',
				'text'    => "Vi har mottagit din förfrågan för bokning av DJ. Vi kommer höra av oss så snart vi kan för att hitta en anpassad offert till just ditt event.\n\n(OBS: Det här meddelandet går inte att svara på, hör av dig till <bokning@platoon.se> istället om det är några oklarheter)\n\n\nMVH//\nPlatoon DJs"
			));

			$data['captcha'] = true;
			$result = $mgClient->sendMessage($domain, array(
				'from'    => getenv('BOOKING_NOREPLY'),
				'to'      => getenv('BOOKING_TO'),
				'subject' => $data['name'].' id:',
				'text'    => print_r($data, true)
			));

			echo json_encode(compact('valid', 'result'));
		} else {
			echo json_encode(compact('valid'));
		}
	}
	
}