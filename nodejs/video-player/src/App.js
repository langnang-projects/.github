import logo from './logo.svg';
import 'antd/dist/antd.css';
import AppRouter from './routes/index';
import './App.css';
import React from 'react';
import { Layout, Menu, Spin, Avatar, BackTop } from 'antd';
import { BrowserRouter as Router, Link } from 'react-router-dom';
import { Scrollbars } from 'react-custom-scrollbars';
const { Header, Content, Footer } = Layout;

export default class App extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			current: 'cupfox',
			loading: true,
			server: false,
		};
	}

	handleClick = (e) => {
		this.setState({ current: e.key });
	};
	componentDidMount() {}
	render() {
		const { current } = this.state;
		return (
			<Layout className="App">
				<Router>
					<Header>
						<div className="logo">
							<img alt="" src={logo}></img>
						</div>
						<Menu onClick={this.handleClick} selectedKeys={[current]} mode="horizontal">
							<Menu.Item key="cupfox">
								<Link to="/cupfox">
									<Avatar src="https://p.qlogo.cn/zc_icon/0/a48ed4731ef857ef4570b4af6ac8c5f216233263757814/0.png" />
									茶杯狐
								</Link>
							</Menu.Item>
							<Menu.Item key="timeline">
								<Link to="/timeline">
									<Avatar src="https://www.bilibili.com/favicon.ico?v=1" />
									新番时间表
								</Link>
							</Menu.Item>
							<Menu.Item key="indexes">
								<Link to="/indexes">
									<Avatar src="https://www.bilibili.com/favicon.ico?v=1" />
									番剧索引
								</Link>
							</Menu.Item>
							<Menu.Item key="/player">
								<Link to="/player">播放器</Link>
							</Menu.Item>
						</Menu>
					</Header>
					<Scrollbars style={{ height: 'calc(100vh - 112px)' }}>
						<Content>
							<AppRouter />
						</Content>
					</Scrollbars>
				</Router>
				<Footer />
				<BackTop />
				<iframe className="api-server" title="" src="https://3dqx3.sse.codesandbox.io/" />
			</Layout>
		);
	}
}
