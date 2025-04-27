import React from 'react';
import { Player as ReactVideo } from 'video-react';
import 'video-react/dist/video-react.css'; // import css
export default class Player extends React.Component {
	constructor(props) {
		super(props);
	}
	render() {
		return (
			<div>
				<ReactVideo>
					<source src="https://cn-zjhz-cu-v-05.bilivideo.com/upgcxcode/28/43/16224328/16224328_da8-1-30080.m4s?e=ig8euxZM2rNcNbdlhoNvNC8BqJIzNbfqXBvEqxTEto8BTrNvN0GvT90W5JZMkX_YN0MvXg8gNEV4NC8xNEV4N03eN0B5tZlqNxTEto8BTrNvNeZVuJ10Kj_g2UB02J0mN0B5tZlqNCNEto8BTrNvNC7MTX502C8f2jmMQJ6mqF2fka1mqx6gqj0eN0B599M=&uipk=5&nbs=1&deadline=1623326770&gen=playurlv2&os=vcache&oi=3707255425&trid=00016291b7a34d624e889913973b660d3175p&platform=pc&upsig=172133ee649c6e3a15af3b63d44989ae&uparams=e,uipk,nbs,deadline,gen,os,oi,trid,platform&cdnid=5180&mid=0&bvc=vod&orderid=0,3&agrr=1&logo=80000000" />
				</ReactVideo>
			</div>
		);
	}
}
