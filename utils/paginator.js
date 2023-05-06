function paginator(items, unit, acessor) {
    
    const page = {};
    const arrayOriginal = items;
    const arrayCopy = new Array(items).concat()[0];

    page.copy = arrayCopy;
    page.all = arrayOriginal;
    page.first = 0;
    page.last = unit;
    page.items = [];
    page.current = 0;
    page.pages = Math.floor(items.length / unit);

    page.nextButton = $("#next");
    page.previousButton = $("#previous");

    page.isFirstPage = true;
    page.isLastPage = false;

    page.init = function() {
        page.items = arrayCopy.slice(page.first, page.last);
        page.isFirstPage = true;
    }

    page.next = function() {
        page.first += unit;
        page.last += unit;
        page.items = [];
        page.current++;

        page.items = arrayCopy.slice(page.first, page.last);
        acessor(page.items);

        if (this.current === this.pages ) {
            page.isLastPage = true;
            page.next = () => null;
        } else {
            page.next = this.next;
            page.isLastPage = true;
        }
    };
    
    page.previous = function() {
        page.first -= unit;
        page.last -= unit
        page.items = [];
        page.current--;
        
        page.items = arrayCopy.slice(page.first, page.last);
        acessor(page.items);
        
        if (this.current === 0) {
            page.previous = () => null;
            page.isFirstPage = true;
        } else {
            page.previous = this.previous;
            page.isFirstPage = true;
        }
    };

    page.init();
    return page
}

