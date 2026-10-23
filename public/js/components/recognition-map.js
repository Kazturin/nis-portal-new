window.nisRecognitionMap = function (countries, locale = 'ru') {
    return {
        countries,
        locale,
        filter: 'all',
        query: '',
        selectedInstitution: null,
        positionedCountries: [],
        resizeObserver: null,
        init() {
            this.$nextTick(() => {
                this.layoutMarkers();
                this.resizeObserver = new ResizeObserver(() => this.layoutMarkers());
                this.resizeObserver.observe(this.$refs.map);
            });
        },
        destroy() {
            this.resizeObserver?.disconnect();
        },
        format(value) {
            return new Intl.NumberFormat(this.locale).format(value);
        },
        get institutions() {
            return this.countries.flatMap(country => country.institutions.map((item, index) => ({
                ...item,
                key: `${country.code}-${index}`,
                countryCode: country.code,
                countryName: country.name,
            })));
        },
        matchesItem(item) {
            const inFilter = this.filter === 'all' || this.filter === item.countryCode;
            const words = this.query.trim().toLocaleLowerCase(this.locale).split(/\s+/).filter(Boolean);
            const text = `${item.name} ${item.countryName} ${item.year} ${item.basis}`.toLocaleLowerCase(this.locale);
            return inFilter && words.every(word => text.includes(word));
        },
        get filteredInstitutions() {
            return this.institutions.filter(item => this.matchesItem(item));
        },
        matchesCountry(country) {
            return country.institutions.some(item => this.matchesItem({ ...item, countryCode: country.code, countryName: country.name }));
        },
        selectCountry(code) {
            this.filter = code;
            this.$nextTick(() => {
                this.$refs.results?.scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth', block: 'nearest' });
                this.$refs.results?.focus({ preventScroll: true });
            });
        },
        openInstitution(item) {
            if (item.url) {
                window.open(item.url, '_blank', 'noopener,noreferrer');
                return;
            }

            this.selectedInstitution = item;
            this.$nextTick(() => this.$refs.dialog.showModal());
        },
        layoutMarkers() {
            const width = this.$refs.map.clientWidth;
            const height = this.$refs.map.clientHeight;
            if (!width || !height) return;
            const markers = this.countries.filter(country => country.count > 0 && country.x !== null && country.y !== null).map(country => {
                const size = Math.min(54, 30 + Math.sqrt(country.count) * 4);
                return { ...country, size, left: country.x / 100 * width, top: country.y / 100 * height };
            });
            // Separate neighboring European markers while retaining their geographic anchors.
            for (let iteration = 0; iteration < 80; iteration++) {
                let moved = false;
                for (let i = 0; i < markers.length; i++) {
                    for (let j = i + 1; j < markers.length; j++) {
                        const a = markers[i], b = markers[j];
                        const dx = b.left - a.left || 0.01, dy = b.top - a.top || 0.01;
                        const distance = Math.hypot(dx, dy);
                        const minimum = (a.size + b.size) / 2 + 4;
                        if (distance >= minimum) continue;
                        const shift = (minimum - distance) / 2;
                        a.left -= dx / distance * shift; a.top -= dy / distance * shift;
                        b.left += dx / distance * shift; b.top += dy / distance * shift;
                        moved = true;
                    }
                }
                for (const marker of markers) {
                    const margin = marker.size / 2 + 2;
                    marker.left = Math.max(margin, Math.min(width - margin, marker.left));
                    marker.top = Math.max(margin, Math.min(height - margin, marker.top));
                }
                if (!moved) break;
            }
            this.positionedCountries = markers;
        },
    };
};
