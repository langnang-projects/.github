import React from 'react';
import { Row, Col, Timeline, Image, Empty } from 'antd';
import { LeftOutlined, RightOutlined } from '@ant-design/icons';
import { get_anime_timeline } from '../../api/bilibili';
import moment from 'moment';
import './index.scss';
export default class BiliBiliTimeLine extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			timeline: [],
			active: 0,
		};
		this.timeline = React.createRef();
	}
	componentDidMount() {
		get_anime_timeline().then((res) => {
			this.setState({
				timeline: res.result,
				active: res.result.findIndex((item) => item.date === moment().format('M-D')),
			});
		});
	}
	scrollPrev = () => {
		if (this.state.active !== 0) {
			this.setState({ active: this.state.active - 1 });
		}
	};
	scrollNext = () => {
		if (this.state.active !== this.state.timeline.length - 1) {
			this.setState({ active: this.state.active + 1 });
		}
	};

	render() {
		const translateX = {
			transform: `translateX(-${(this.state.active > this.state.timeline.length - 4 ? this.state.timeline.length - 4 : this.state.active) * 100}%)`,
		};
		return (
			<div className="app-container bilibili-anime--timeline__wrapper">
				<LeftOutlined onClick={this.scrollPrev} />
				<Row>
					{this.state.timeline.length > 0 &&
						this.state.timeline.map((item, index) => {
							return (
								<Col className={index === this.state.active ? 'active' : ''} span={6} key={item.date} style={translateX}>
									<h1 className="text-center">{item.date}</h1>
									<Timeline>
										{item.seasons.length > 0 ? (
											item.seasons.map((sea) => {
												return (
													<Timeline.Item key={sea.ep_id}>
														<span>{sea.pub_time}</span>
														<Image width={72} src={'https://3dqx3.sse.codesandbox.io/image.hdslb?url=' + sea.square_cover + '@144w_144h.webp'} />
														<span>
															{sea.title}
															{sea.pub_index}
														</span>
													</Timeline.Item>
												);
											})
										) : (
											<Empty />
										)}
									</Timeline>
								</Col>
							);
						})}
				</Row>
				<RightOutlined onClick={this.scrollNext} />
			</div>
		);
	}
}
