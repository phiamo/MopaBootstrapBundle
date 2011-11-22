
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Go to the list view
        $crawler = $client->request('GET', '/{{ route_prefix }}/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());

        // Go to the show view
        $crawler = $client->click($crawler->selectLink('show')->link());
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }