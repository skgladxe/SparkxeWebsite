@include('webadmin.partials.sidebar.menu-group', ['label' => 'Apps'])

<x-webadmin::sidebar.menu-item href="chat.html" title="Chat" icon="fi fi-rr-comment" />
<x-webadmin::sidebar.menu-item href="calendar.html" title="Calendar" icon="fi fi-rr-calendar" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Email', 'divider' => true])

<x-webadmin::sidebar.menu-item href="email/inbox.html" title="Inbox" icon="fi fi-rr-inbox-in" />
<x-webadmin::sidebar.menu-item href="email/compose.html" title="Compose" icon="fi fi-rr-pen-field" />
<x-webadmin::sidebar.menu-item href="email/read-email.html" title="Read email" icon="fi fi-rr-envelope" />
