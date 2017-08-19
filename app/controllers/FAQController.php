<?php


/**
 * FAQController
 */
class FAQController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->data['title'] = 'FAQ';
        $this->data['slug'] = 'faq';

        $data = json_decode(@file_get_contents(__DIR__ . '/../data/faq.json'), true);

        foreach ($data['sections'] as &$section) {
          foreach ($section['faq'] as &$faq) {
            $faq['slug'] = $this->slugify($faq['q']);
          }
        }

        $this->data['faq'] = $data;
    }

    protected function slugify($str)
    {
      $stripped = preg_replace(['/\s+/', '/[\t\n]/'], '-', strtolower(strtr($str, [
        'å' => 'a',
        'ä' => 'a',
        'ö' => 'o',
      ])));
      return preg_replace('/[^a-z\-]/', '', $stripped);
    }

    public function index()
    {
        $this->render('@pages/faq/index.twig');
    }

    public function section($section)
    {
        $sectionIdx = array_search($section, array_column($this->data['faq']['sections'], 'slug'));

        if ($sectionIdx !== false) {
          $sectionData = $this->data['faq']['sections'][$sectionIdx];
          return $this->render('@pages/faq/section.twig', [
            'data' => $sectionData,
            'title' => $sectionData['title'],
          ]);
        }

        return $this->app->notFound();
    }

    public function question($section, $question)
    {
        $sectionIdx = array_search($section, array_column($this->data['faq']['sections'], 'slug'));

        if ($sectionIdx !== false) {
          $sectionData = $this->data['faq']['sections'][$sectionIdx];
          $questionIdx = array_search($question, array_column($sectionData['faq'], 'slug'));
          if ($questionIdx !== false) {
            $questionData = $sectionData['faq'][$questionIdx];
            $prevData = $questionIdx > 0 ? $sectionData['faq'][$questionIdx - 1] : false;
            $nextData = $questionIdx < count($sectionData['faq']) - 1 ? $sectionData['faq'][$questionIdx + 1] : false;
            return $this->render('@pages/faq/question.twig', [
              'section' => $sectionData,
              'data' => $questionData,
              'prev' => $prevData,
              'next' => $nextData,
              'title' => $questionData['q'],
            ]);
          }
        }

        return $this->app->notFound();
    }

}
