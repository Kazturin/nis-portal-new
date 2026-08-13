import TableCell from '@tiptap/extension-table-cell'

const extension = TableCell.extend({
    addAttributes() {
        return {
            ...this.parent?.(),
            backgroundColor: {
                default: null,
                parseHTML: element => element.style.backgroundColor || element.getAttribute('data-bg-color') || null,
                renderHTML: attributes => {
                    if (!attributes.backgroundColor) {
                        return {}
                    }
                    
                    return {
                        'data-bg-color': attributes.backgroundColor,
                        style: `background-color: ${attributes.backgroundColor}`,
                    }
                },
            },
        }
    },
})

export default extension;
