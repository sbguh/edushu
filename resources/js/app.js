/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

require('./components/SelectDistrict');
require('./components/UserAddressesCreateAndEdit');

import Plyr from 'plyr';

import "weui";

//import { dataURLToBlob }  from 'blob-util'

//window.dataURLToBlob = dataURLToBlob;
//import jdMusic from 'jdf2e-audio';

//window.jdMusic = jdMusic;
//const player = new Plyr('#player', {debug:true});

window.Plyr = Plyr;

import 'vant/lib/index.css';
import { Toast } from 'vant';
import { Card } from 'vant';
import { Tag } from 'vant';
import { Button } from 'vant';
import { Search } from 'vant';
import { NumberKeyboard } from 'vant';
import { List } from 'vant';
import { Col, Row } from 'vant';
import { Tab, Tabs } from 'vant';
import { GoodsAction, GoodsActionIcon, GoodsActionButton } from 'vant';
import { DropdownMenu, DropdownItem } from 'vant';
import { Image } from 'vant';
import { Panel } from 'vant';
import { Divider } from 'vant';
import { Tabbar, TabbarItem } from 'vant';
import { NavBar } from 'vant';
import { SwipeCell } from 'vant';
import { Pagination } from 'vant';
import { Cell, CellGroup } from 'vant';
import { Popup } from 'vant';
import { Collapse, CollapseItem } from 'vant';

Vue.use(Collapse);
Vue.use(CollapseItem);
Vue.use(Popup);

Vue.use(Cell);
Vue.use(CellGroup);

Vue.use(Pagination);

Vue.use(SwipeCell);
Vue.use(NavBar);
Vue.use(Tabbar);
Vue.use(TabbarItem);
Vue.use(Divider);
Vue.use(Panel);
Vue.use(Image);

Vue.use(DropdownMenu);
Vue.use(DropdownItem);

Vue.use(GoodsAction);
Vue.use(GoodsActionButton);
Vue.use(GoodsActionIcon);

Vue.use(Tab);
Vue.use(Tabs);

Vue.use(Col);
Vue.use(Row);

Vue.use(List);
Vue.use(NumberKeyboard);
Vue.use(Search);
Vue.use(Card);
Vue.use(Tag);
Vue.use(Button);
Vue.use(Toast);

window.Toast = Toast;
//require('jplayer');

// Expose player so it can be used from the console
//window.player = player;



//const {Howl, Howler} = require('howler');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
