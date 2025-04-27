import React from 'react';
import { Switch, Route } from 'react-router-dom';

import CupfoxIndex from './../views/cupfox/index';

import BiliBiliTimeLine from './../views/TimeLine/index';
import BiliBiliIndexes from './../views/Indexes';
import Player from './../components/Player';

const routes = [
	{
		path: '/cupfox',
		component: CupfoxIndex,
	},
	{
		path: '/timeline',
		component: BiliBiliTimeLine,
	},
	{
		path: '/indexes',
		component: BiliBiliIndexes,
	},
	{
		path: '/player',
		component: Player,
	},
	// {
	// 	path: '/tacos',
	// 	component: Tacos,
	// 	routes: [
	// 		{
	// 			path: '/tacos/bus',
	// 			component: Bus,
	// 		},
	// 		{
	// 			path: '/tacos/cart',
	// 			component: Cart,
	// 		},
	// 	],
	// },
];

export default class AppRouter extends React.Component {
	render() {
		return (
			<Switch>
				{routes.map((route, i) => (
					<Route key={i} path={route.path} render={() => <route.component {...route} routes={route.routes} />} />
				))}
			</Switch>
		);
	}
}
