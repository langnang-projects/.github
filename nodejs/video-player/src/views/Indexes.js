import React from 'react';
import { Row, Col, Card, List } from 'antd';
import { get_anime_indexes } from '../api/bilibili';
import InfiniteScroll from 'react-infinite-scroller';
const { Meta } = Card;
export default class BiliBiliIndexes extends React.Component {
	state = {
		indexes: [],
	};
	componentDidMount() {
		this.handleInfiniteOnLoad(1);
	}
	handleInfiniteOnLoad = (page) => {
		let { indexes } = this.state;
		get_anime_indexes({
			page,
		}).then((res) => {
			indexes = indexes.concat(res.data.list);
			this.setState({ indexes });
		});
	};
	render() {
		return (
			<InfiniteScroll initialLoad={false} pageStart={1} loadMore={this.handleInfiniteOnLoad} hasMore={true} useWindow={false}>
				<List
					grid={{ column: 4 }}
					dataSource={this.state.indexes}
					renderItem={(item) => (
						<List.Item>
							<Card hoverable style={{ width: 240 }} cover={<img alt={item.title} src={'https://3dqx3.sse.codesandbox.io/image.hdslb?url=' + item.cover} />}>
								<Meta title={item.title} description={item.index_show} />
							</Card>
						</List.Item>
					)}
				/>
			</InfiniteScroll>
		);
	}
}
