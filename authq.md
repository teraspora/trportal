Using Cake 3.8.

I am trying to implement user authentication and authorisation using the default `Auth` component.

I have followed the Blog tutorial from the Book:

1. I successfully implemented password hashing.
2. In my `AppController`'s I added Auth code so the `initialize()` method looks like this:
```
public function initialize() {
    parent::initialize();

    $this->loadComponent('Flash');
    $this->loadComponent('RequestHandler', [
        'enableBeforeRedirect' => false,
    ]);
    // $this->loadComponent('Auth', ['authenticate' => [            
    //         'Form' => [
    //             'fields' => [
    //                 'username' => 'email',
    //                 'password' => 'password'
    //             ]
    //         ]
    //     ],
    //     'loginAction' => [
    //         'controller' => 'Users',
    //         'action' => 'login']
    // ]);

    $this->loadComponent('Auth', [
        'loginRedirect' => [
            'controller' => 'Results',
            'action' => 'index'
        ],
        'logoutRedirect' => [
            'controller' => 'Users',
            'action' => 'login',
            'home'
        ]
    ]);
}
```
3. 
