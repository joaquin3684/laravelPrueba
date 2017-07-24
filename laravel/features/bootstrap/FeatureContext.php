<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Snippet\Snippet;
use Behat\Mink\Driver\Selenium2Driver;
use PHPUnit_Framework_Assert as PHPUnit;
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    private $page;
    public function __construct()
    {

    }


    /**
     * @Given estoy en :a
     */
    public function estoyEnOrganismos($a){
        $this->visitPath($a);
       $this->page =  $this->getSession()->getPage();
    }
    /**
     * @Then la URL debe seguir el patron :a
     */
    public function estoyEnOrganismo($a)
    {
        //$page = $this->getSession()->getPage();

        //$this->assertSession()->elementExists('css', '#nombre');
        $this->assertUrlRegExp($a);
    }

    /**
     * @When  voy a :a
     */
    public function voya($a)
    {
        $this->visit($a);
    }


    /**
     * @When relleno usuario con :arg1
     */
    public function rellenoNombreConEjercito($arg1)
    {
        $this->fillField('usuario', $arg1);
    }

    /**
     * @When relleno password con :arg1
     */
    public function rellenoCuitCon($arg1)
    {
       $this->fillField('password', $arg1);
       $a = $this->page->find('css', '#usuario');
    }

    /**
     * @When cuota_social con :arg1
     */
    public function cuotaSocialCon($arg1)
    {
        $this->fillField('cuota_social', $arg1);
    }

    /**
     * @When presiono :button
     */
    public function presionoEnviar($button)
    {
        $this->pressButton($button);

    }

    /**
     * @Then se cargan los elementos
     */
    public function seCarganLosElementos()
    {
        $socio = \App\Organismos::find(1);
        $repo = new \App\Repositories\Eloquent\Repos\OrganismosRepo();
       $actual =  $repo->find(1);
       $expected = new \App\Repositories\Eloquent\Organismo(1, 'ejercito', 1234, 200);
       PHPUnit::assertEquals($expected, $actual);
    }

}
