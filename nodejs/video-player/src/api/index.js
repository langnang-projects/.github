import axios from './../plugins/axios';

export const link_server = () => {
	return axios({
		method: 'get',
		url: 'https://3dqx3.sse.codesandbox.io/',
	});
};
