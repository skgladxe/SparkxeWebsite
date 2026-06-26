@include('webadmin.partials.sidebar.menu-group', ['label' => 'Login'])

<x-webadmin::sidebar.menu-item href="authentication/login-basic.html" title="Basic" icon="fi fi-rr-unlock" />
<x-webadmin::sidebar.menu-item href="authentication/login-cover.html" title="Cover" icon="fi fi-rr-unlock" />
<x-webadmin::sidebar.menu-item href="authentication/login-frame.html" title="Frame" icon="fi fi-rr-unlock" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Register', 'divider' => true])

<x-webadmin::sidebar.menu-item href="authentication/register-basic.html" title="Basic" icon="fi fi-rr-enter" />
<x-webadmin::sidebar.menu-item href="authentication/register-cover.html" title="Cover" icon="fi fi-rr-enter" />
<x-webadmin::sidebar.menu-item href="authentication/register-frame.html" title="Frame" icon="fi fi-rr-enter" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Forgot Password', 'divider' => true])

<x-webadmin::sidebar.menu-item href="authentication/forgot-password-basic.html" title="Basic" icon="fi fi-rs-otp" />
<x-webadmin::sidebar.menu-item href="authentication/forgot-password-cover.html" title="Cover" icon="fi fi-rs-otp" />
<x-webadmin::sidebar.menu-item href="authentication/forgot-password-frame.html" title="Frame" icon="fi fi-rs-otp" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'New Password', 'divider' => true])

<x-webadmin::sidebar.menu-item href="authentication/new-password-basic.html" title="Basic" icon="fi fi-rr-password-alt" />
<x-webadmin::sidebar.menu-item href="authentication/new-password-cover.html" title="Cover" icon="fi fi-rr-password-alt" />
<x-webadmin::sidebar.menu-item href="authentication/new-password-frame.html" title="Frame" icon="fi fi-rr-password-alt" />
