const axiosError = (type, e) => {
	switch (type) {
		case 200: {
			console.error(`💔 Axios did not get 200. ${e}`)
			return { axiosError: 200 }
		}
		default:
			console.error(`💔 Axios: ${e}`)
			return { axiosError: `${e}` }
	}
}

export default axiosError
