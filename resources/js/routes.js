import App          from './Components/App.vue';
import FriendList   from './Components/FriendList';
import FriendDetail from './Components/FriendDetail';
import TagPage      from './Components/TagPage';
import CreateTag    from './Components/CreateTag';


export const routes = [
  {
    name     : 'home',
    path     : '*',
    component: App,
  },
  {
    name     : 'friends.index',
    path     : '/friends',
    component: FriendList,
    props    : true,
  },
  {
    name     : 'friends.detail',
    path     : '/friends/:id',
    component: FriendDetail,
    props    : true,
  },
  {
    name     : 'tags.index',
    path     : '/tags',
    component: TagPage,
  },
  {
    name     : 'tags.create',
    path     : '/tags/create',
    component: CreateTag,
  },
];
