/*
 * DO NOT REMOVE THIS NOTICE
 *
 * PROJECT:   js libs
 * COPYRIGHT: (c) 2003,2004 Cezary Tomczak
 * LINK:      http://gosu.pl
 * LICENSE:   BSD (revised)
 */
 
/* Check whether array contains given string */
Array.prototype.contains = function(s) {
    for (var i = 0; i < this.length; ++i) {
        if (this[i] === s) { return true; }
    }
    return false;
};

/* Indicates whether some other array is "equal to" this one */
Array.prototype.equals = function(a) {
    if (this.length != a.length) { return false; }
    for (var i = 0; i < this.length; ++i) {
        if (this[i] !== a[i]) { return false; }
    }
    return true;
};

/* Finds the index of the first occurence of item in the array, or -1 if not found */
Array.prototype.indexOf = function(item) {
    for (var i = 0; i < this.length; ++i) {
        if (this[i] === item) { return i; }
    }
    return -1;
};

/* Get the last element from the array */
Array.prototype.getLast = function() {
    return this[this.length-1];
};

/* Remove elements judged 'false' by the passed function (mutates) */
Array.prototype.filter = function(func) {
    var i, indexes = [];
    for (i = 0; i < this.length; ++i) {
        if (!func(this[i])) { indexes.push(i); }
    }
    for (i = indexes.length - 1; i >= 0; --i) {
        this.splice(indexes[i], 1);
    }
};

/* Apply custom function to every element of an array (mutates) */
Array.prototype.map = function(func) {
    for (var i = 0; i < this.length; ++i) {
        this[i] = func(this[i]);
    }
};

/* Push an element at specified index */
Array.prototype.pushAtIndex = function(el, index) {
    this.splice(index, 0, el);
};

/* Remove element with given index (mutates) */
Array.prototype.removeByIndex = function(index) {
    this.splice(index, 1);
};

/* Remove elements with such value (mutates) */
Array.prototype.removeByValue = function(value) {
    var i, indexes = [];
    for (i = 0; i < this.length; ++i) {
        if (this[i] === value) { indexes.push(i); }
    }
    for (i = indexes.length - 1; i >= 0; --i) {
        this.splice(indexes[i], 1);
    }
};
 
/* Remove duplicate values (mutates)
 * Dependencies: Array.indexOf() */
Array.prototype.removeDuplicates = function() {
    var i, unique = [], indexes = [];
    for (i = 0; i < this.length; ++i) {
        if (unique.indexOf(this[i]) == -1) { unique.push(this[i]); }
        else { indexes.push(i); }
    }
    for (i = indexes.length - 1; i >= 0; --i) {
        this.splice(indexes[i], 1);
    }
};
 
/* Returns copy of an array */
Array.prototype.copy = function() {
    var copy = [];
    for (var i = 0; i < this.length; ++i) {
        copy[i] = (typeof this[i].copy != "undefined") ? this[i].copy() : this[i];
    }
    return copy;
};
 
/* Swaps the values of two indicies (mutates) */
Array.prototype.swap = function(index1, index2) {
    var temp = this[index1];
    this[index1] = this[index2];
    this[index2] = temp;
};

/* Randomly shuffles array (mutates)
 * Dependencies: Array.swap() */
Array.prototype.shuffle = function() {
    for (var i = 0; i < this.length; ++i) {
        var ind1 = Math.floor(Math.random() * this.length);
        var ind2 = Math.floor(Math.random() * this.length);
        this.swap(ind1, ind2);
    }
};