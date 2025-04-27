import React from 'react';
import { Row, Col, Form, Radio, List, Card, Spin } from 'antd';
import { get_cupfox_command } from './../../api/cupfox';
import InfiniteScroll from 'react-infinite-scroller';
import { Scrollbars } from 'react-custom-scrollbars';

const typeOptions = [
	{ label: '电影', value: 'movie' },
	{ label: '剧集', value: 'tv' },
];
const tagOptions = ['热门', '华语', '欧美', '韩国', '日本', '动作', '喜剧', '爱情', '科幻', '悬疑', '恐怖'].map((item) => {
	return { label: item, value: item };
});
export default class Cupfox extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			type: 'movie',
			tag: '华语',
			data: [],
			loading: true,
			hasMore: true,
			pageNum: 1,
			pageSize: 24,
		};
	}
	componentDidMount() {
		this.getCupfoxCommand();
	}
	getCupfoxCommand = (subject, page = 1) => {
		this.setState({ loading: true });
		get_cupfox_command({
			subject: this.state.type + '_' + this.state.tag,
			page_start: 0,
			page_limit: this.state.pageSize,
		}).then((res) => {
			this.setState({ data: res.subjects, loading: false });
		});
	};
	componentDidUpdate(prevProps, prevState) {
		console.log(this.state);
		console.log(prevProps, prevState);
	}
	handleInfiniteOnLoad = () => {
		console.log('handleInfiniteOnLoad');
		this.setState({ loading: true });
		get_cupfox_command({
			page_start: this.state.pageNum * this.state.pageSize,
			page_limit: this.state.pageSize,
		}).then((res) => {
			let hasMore = true;
			if (res.subjects.length < this.state.pageSize) {
				hasMore = false;
			}
			this.setState({ data: [...this.state.data, ...res.subjects], loading: false, pageNum: this.state.pageNum + 1, hasMore });
		});
	};
	render() {
		const { data } = this.state;
		return (
			<Row className="app-container">
				<Col span={24}>
					<Form>
						<Form.Item label="Type" name="type">
							<Radio.Group
								value={this.state.type}
								options={typeOptions}
								buttonStyle="solid"
								optionType="button"
								onChange={(e) => this.setState({ type: e.target.value })}
							></Radio.Group>
						</Form.Item>
						<Form.Item label="Tag" name="tag">
							<Radio.Group
								value={this.state.tag}
								buttonStyle="solid"
								options={tagOptions}
								optionType="button"
								onChange={(e) => this.setState({ tag: e.target.value })}
							></Radio.Group>
						</Form.Item>
					</Form>
				</Col>
				<Col span={24}>
					<Spin spinning={this.state.loading}>
						<Scrollbars style={{ height: 500 }}>
							<InfiniteScroll initialLoad={false} pageStart={0} loadMore={this.handleInfiniteOnLoad} hasMore={this.state.hasMore} useWindow={false}>
								<List
									grid={{
										xs: 1,
										sm: 2,
										md: 4,
										lg: 4,
										xl: 6,
										xxl: 8,
									}}
									dataSource={data}
									renderItem={(item) => (
										<List.Item>
											<Card cover={<img alt={item.title} src={'https://3dqx3.sse.codesandbox.io/image/proxy?url=' + item.cover} />}>{item.title}</Card>
										</List.Item>
									)}
								/>
							</InfiniteScroll>
						</Scrollbars>
					</Spin>
				</Col>
			</Row>
		);
	}
}
