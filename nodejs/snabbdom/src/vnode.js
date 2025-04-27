/**
 *
 * @param tag 标签名
 * @param data 标签属性
 * @param children 子标签
 * @param text 文本
 * @param elm
 * @returns {{data, children, elm, tag, text}}
 */
export default function vnode(tag, data, children, text, elm) {
  const key = data.key;
  return { tag, data, children, text, elm, key };
}
