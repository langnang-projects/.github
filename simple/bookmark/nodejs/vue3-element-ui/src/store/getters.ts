export default {
  sites: (state: any) => state.sites.sort((a: any, b: any) => b.sortWeight - a.sortWeight),
  tags: (state: any) => [
    ...new Set(
      state.sites.reduce((tol: any, item: any) => tol.concat(item.tags || []), [])
    ),
  ],
}
