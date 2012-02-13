# PHP SDK for Robowhois APIs

## DIC configuration

    $container = new ContainerBuilder();
    $container
        ->register('robowhois', '%robowhois.class%')
        ->addArgument('%robowhois.apiKey%')
        ->addArgument('%robowhois.http.client%')
    ;
    $container->setParameter('robowhois.class', 'Robowhois\Robowhois');
    $container->setParameter('robowhois.apiKey', $this->getApiKey());
    $container->setParameter('robowhois.http.client', new Client(new Browser));

    return $container->get('robowhois');
