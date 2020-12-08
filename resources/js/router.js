import Browse from './views/Browse';
import RecentlyAdded from './views/RecentlyAdded';
import Queue from './views/Queue';

export const routes = [
    {
        path: '/',
        component: Browse,
        name: 'browse',
    },

    {
        path: '/recently-added',
        component: RecentlyAdded,
        name: 'recently-added',
    },

    {
        path: '/queue',
        component: Queue,
        name: 'queue',
    },

    {
        path: '/artists',
        component: import('./views/Artists/Index'),
        name: 'artists',
    },

    {
        path: '/artists/:id',
        component: import('./views/Artists/Show'),
        name: 'artist',
    },

    {
        path: '/albums',
        component: import('./views/Albums/Index'),
        name: 'albums',
    },

    {
        path: '/albums/:id',
        component: import('./views/Albums/Show'),
        name: 'album',
    },
];
